<?php
// MedicalApplicationController.php
require_once '../models/patientMedicalApplicationModel.php';
require_once '../models/doctorModel.php';
require_once '../Observers/ISubject.php';
class MedicalApplicationController implements ISubject{
    public function index($action = null) {
        // Route based on action parameter
        switch ($action) {
            case 'listApplications':
                $this->listApplications();
                break;
            case 'showAddApplicationForm':
                $this->showAddApplicationForm();
                break;
            case 'addApplication':
                $this->addApplication();
                break;
            case 'addAidtype':
                $this->addAidtype();
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
        include '../views/medicalApplicationView.php'; // Assume this view lists applications
    }

    // Show the form to add a new medical aid application
    private function showAddApplicationForm() {
        include '../views/medicalApplicationAddView.php'; // Assume this view has the form to add applications
    }

    // Handle adding a new medical aid application
    private function addApplication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $status_id = $_POST['status_id'] ?? 1;

            if (PatientMedicalApplicationModel::add_patient_application($patient_id, $doctor_id)) {
                // Notify all doctors
                $this->NotifyObserver($patient_id);

                header('Location: index.php?view=medicalApplication&action=listApplications');
                exit();
            } else {
                echo "Error: Unable to add application.";
            }
        } else {
            $this->showAddApplicationForm();
        }
    }
    private function addAidtype(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $medicalApplicationId = $_POST['patient_application_id'];
            $selectedAidTypes = $_POST['aid_type'];
        
            // Validate the data (optional, but recommended)
            // ...
        
            // Process the selected aid types
            foreach ($selectedAidTypes as $aidType) {
                pmaAidTypeModel::add_entry((int)$medicalApplicationId,(int)$aidType);
            }
        
            // Redirect to a success page or display a success message

        }
        
    }
    public function NotifyObserver(int $patient_id):void {
        $doctors = Doctor::get_all_doctors_details();
        foreach ($doctors as $doctor) {
            $doctor->update_obeserver($patient_id); // Notify each doctor
        }
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
