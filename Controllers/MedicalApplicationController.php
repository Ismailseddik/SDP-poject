<?php
// MedicalApplicationController.php
require_once '../models/patientMedicalApplicationModel.php';
require_once '../models/doctorModel.php';
require_once '../Observers/ISubject.php';
require_once '../Commands/CommandHistory.php';
require_once '../Decorators/AidTypeDecorator.php';
require_once '../Decorators/FinancialAid.php';
require_once '../Decorators/MedicalAid.php';
require_once '../Decorators/OperationalAid.php';
require_once '../Commands/AddAidTypeCommand.php';
require_once '../Iterator/Iterators.php';

class MedicalApplicationController extends Iterators implements ISubject{
    private $logs = [];
    public function logMessage(string $message): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['logs'])) {
            $_SESSION['logs'] = [];
        }
        $_SESSION['logs'][] = $message;
    }
    
    public function getLogs(): array {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION['logs'] ?? [];
    }
    
    public function clearLogs(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['logs'] = [];
    }
    public function index($action = null) {
        // Route based on action parameter
        switch ($action) {
            case 'listApplications':
                $this->listApplications();
                break;
            case 'showAddApplicationForm':
                $this->showAddApplicationForm();
                break;
            case 'showAddAidTypeForm': // NEW CASE for Add Aid Type View
                $this->showAddAidTypeForm();
                break;
            case 'addApplication':
                $this->addApplication();
                break;
            case 'addAidtype':
                $this->addAidtype();
                break;
            case 'undoLastAction': // New undo action
                $this->undoLastAction();
                break;
            // case 'updateStatus':
            //     // $this->updateStatus();
            //     break;
            // case 'viewApplicationDetails':
            //     // $this->viewApplicationDetails();
            //     break;
            default:
                echo "Error: Action not recognized in MedicalApplicationController.";
                break;
        }
    }

    // Display a list of all medical aid applications
    private function listApplications() {
        $applications = PatientMedicalApplicationModel::get_all_applications();
    // Debugging step to check for duplicates:
        error_log(print_r($applications, true));
        $logs = $this->getLogs();
        include '../views/medicalApplicationView.php'; // Assume this view lists applications
        $this->clearLogs();
    }

    // Show the form to add a new medical aid application
    private function showAddApplicationForm() {
        include '../views/medicalApplicationAddView.php'; // Assume this view has the form to add applications
    }
    private function showAddAidTypeForm() {
        $applicationId = $_GET['application_id'] ?? null; // Get application ID from query parameters
        if ($applicationId) {
            // Fetch the existing aid types for the application
            $existingAidTypes = pmaAidTypeModel::get_by_patient_application_id($applicationId);
    
            // Pass the application ID and existing aid types to the view
            include '../Views/medicalApplicationAddAidTypeView.php';
        } else {
            echo "Error: Application ID is required to assign aid types.";
        }
    }
    // Handle adding a new medical aid application
    private function addApplication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $status_id = $_POST['status_id'] ?? 1;
            $aid_types = $_POST['aid_types'] ?? [];

            if (PatientMedicalApplicationModel::add_patient_application($patient_id, $doctor_id)) {
                // if (!PatientMedicalApplicationModel::add_aid_types($application_id, $aid_types)) {
                //     echo "Error: Unable to add aid types.";
                //     return;
                // }
                // Notify all doctors
                $this->NotifyObserver();

                header('Location: index.php?view=medicalApplication&action=listApplications');
                exit();
            } else {
                echo "Error: Unable to add application.";
            }
        } else {
            $this->showAddApplicationForm();
        }
    }
    private CommandHistory $history;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Restore history from session or initialize a new one
        if (!isset($_SESSION['command_history'])) {
            $_SESSION['command_history'] = new CommandHistory();
        }
        $this->history = $_SESSION['command_history'];
    }
    // Save the history back to the session after modifications
    private function saveHistory() {
        $_SESSION['command_history'] = $this->history;
    }
    private function addAidtype() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Step 1: Retrieve application ID and aid types
            $medicalApplicationId = $_POST['Medical_application_id'];
            $selectedAidTypes = $_POST['aid_type']; // Array of selected aid types
            $this->logMessage("Processing aid types for application ID: $medicalApplicationId");
            // Step 2: Fetch existing aid types for the application
            $existingAidTypes = array_map(
                fn($aidTypeModel) => $aidTypeModel->get_aid_type_id(),
                pmaAidTypeModel::get_by_patient_application_id($medicalApplicationId)
            );
    
            // Step 3: Add only non-duplicate aid types
            $itr = self::getArrayIterator();
            $itr->SetIterable($selectedAidTypes);
            while($itr->HasNext()) 
            {
                $aidType = $itr->Next();
                if (in_array((int)$aidType, $existingAidTypes)) 
                {
                    $this->logMessage("Skipping duplicate aid type: $aidType");
                    continue;
                }
    
                $data = [
                    'patient_application_id' => $medicalApplicationId,
                    'aid_type_id' => $aidType,
                ];
    
                // Dynamically assign the appropriate concrete class to the decorator
                switch ((int)$aidType) 
                {
                    case 1:
                        $this->logMessage("Creating FinancialAid decorator");
                        $decorator = new FinancialAid(new pmaAidTypeModel($data));
                        break;
                    case 2:
                        $this->logMessage("Creating MedicalAid decorator");
                        $decorator = new MedicalAid(new pmaAidTypeModel($data));
                        break;
                    case 3:
                        $this->logMessage("Creating OperationalAid decorator");
                        $decorator = new OperationalAid(new pmaAidTypeModel($data));
                        break;
                    default:
                        $this->logMessage("Invalid aid type selected: $aidType");
                        echo "Error: Invalid aid type selected.";
                        return;
                }
    
                if ($decorator instanceof AidTypeDecorator)
                {
                    $this->logMessage("Executing command for aid type: $aidType");
                    $command = new AddAidTypeCommand($decorator, (int)$aidType,$medicalApplicationId);
                    $command->execute();
                    $this->history->push($command);
                    $this->logMessage("Successfully added aid type: $aidType");
                } 
                else 
                {
                    $this->logMessage("Failed to create a valid decorator for aid type: $aidType");
                    echo "Error: Failed to create a valid decorator.";
                    return;
                }
            }
    
            // Step 4: Use PRG pattern to avoid duplicate submissions
            $_SESSION['message'] = "Aid types added successfully.";
            $this->saveHistory();
            header('Location: index.php?view=medicalApplication&action=listApplications');
            exit();
        }
    }
     
    
    
    
    private function undoLastAction() {
        if (!$this->history->isEmpty()) {
            $lastCommand = $this->history->pop();
            $lastCommand->undo();
            $this->saveHistory();
            echo "Last action undone successfully.";
        } else {
            echo "No actions to undo.";
        }
            // Redirect back to the medical application view
        header('Location: index.php?view=medicalApplication&action=listApplications');
    }
        
    
    public function NotifyObserver(): void {
        // Fetch all doctors
        $doctors = Doctor::get_all_doctors_details();
        // Distribute the applications to the relevant doctors
        $itr = self::getArrayIterator();
        $itr->SetIterable($doctors);
        while($itr->HasNext())
        {
            $itr->Next()->update_obeserver();
        }
        // foreach ($doctors as $doctor) { $doctor->update_obeserver();}
    }
    
    // Update the status of an existing medical aid application
    // private function updateStatus() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Retrieve application ID and new status ID from POST request
    //         $application_id = $_POST['application_id'];
    //         $status_id = $_POST['status_id'];

    //         // Attempt to update the application status
    //         if (PatientMedicalApplicationModel::updateApplicationStatus($application_id, $status_id)) {
    //             echo "Application status updated successfully.";
    //         } else {
    //             echo "Error: Unable to update application status.";
    //         }
    //     }
    // }

    // View details of a specific application
    // private function viewApplicationDetails() {
    //     if (isset($_GET['application_id'])) {
    //         $application_id = (int)$_GET['application_id'];
    //         $application = MedicalApplication::getApplicationDetails($application_id);

    //         if ($application) {
    //             include '../views/medicalApplicationDetailView.php'; // Assume this view displays application details
    //         } else {
    //             echo "Error: Application not found.";
    //         }
    //     } else {
    //         echo "Error: Application ID not provided.";
    //     }
    // }
}
