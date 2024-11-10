<?php
// PatientController.php
require_once '../models/patientModel.php';

class PatientController
{
    public function index($action = null)
    {
        switch ($action) {
            case 'listPatients':
                $this->listPatients();
                break;
            case 'showAddPatientForm':
                $this->showAddPatientForm();
                break;
            case 'addPatient':
                $this->addPatient();
                break;
            default:
                echo "Error: Action not recognized in PatientController.";
                break;
        }
    }

    // Display the list of patients
    private function listPatients()
    {
        $patients = Patient::getAllPatients();
        include '../views/patientView.php';
    }

    // Display the add patient form
    private function showAddPatientForm()
    {
        include '../views/patientView.php';
    }

    // Handle the form submission for adding a new patient
    private function addPatient()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Split the name into first and last names
            $full_name = $_POST['patient_name'] ?? '';
            $name_parts = explode(' ', $full_name, 2);
            $first_name = $name_parts[0] ?? '';
            $last_name = $name_parts[1] ?? '';

            $age = (int)$_POST['patient_age'] ?? 0;

            // Pass the correct parameters to addPatient
            $result = Patient::addPatient($first_name, $last_name, $age);

            if ($result) {
                header('Location: index.php?view=patient&action=listPatients');
                exit();
            } else {
                echo "Error: Unable to add patient. Please try again.";
            }
        } else {
            $this->showAddPatientForm();
        }
    }
}
