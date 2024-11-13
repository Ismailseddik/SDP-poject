<?php
// MedicalApplicationController.php
require_once '../models/patientMedicalApplicationModel.php';

class MedicalApplicationController {
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
            // Retrieve form data from POST request
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $status_id = $_POST['status_id'] ?? 1; // Default to 'Pending' status

            // Attempt to add a new application
            if (PatientMedicalApplicationModel::add_patient_application($patient_id, $doctor_id)) {
                // Redirect to the application list if successful
                header('Location: index.php?view=medicalApplication&action=listApplications');
                exit();
            } else {
                echo "Error: Unable to add application.";
            }
        } else {
            // Show the add form if the request is not POST
            $this->showAddApplicationForm();
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
