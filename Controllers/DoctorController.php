<?php
require_once '../Models/doctorModel.php';

class DoctorController
{
    // Central function to handle various actions
    public function index($action = null)
    {
        switch ($action) {
            case 'listDoctors':
                $this->listDoctors();
                break;

            case 'addDoctor':
                $this->addDoctor();
                break;

            default:
                $this->listDoctors(); // Default to listing doctors
                break;
        }
    }

    // Function to display a list of doctors and show the add form
    private function listDoctors()
    {
        $doctorModel = new Doctor();
        $doctors = $doctorModel->get_all();
        include '../views/doctorView.php'; // Same view for listing and adding
    }

    // Function to add a new doctor to the database
    private function addDoctor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $fname = $_POST['doctor_fname'] ?? '';
            $lname = $_POST['doctor_lname'] ?? '';
            $specialty = $_POST['doctor_specialty'] ?? '';
            $available_times = $_POST['doctor_available_times'] ?? '';
            $birth_date = $_POST['doctor_birthdate'] ?? '';

            // Convert birth date to DateTime object
            $birthDateObj = DateTime::createFromFormat('Y-m-d', $birth_date);

            if ($birthDateObj === false) {
                echo "Error: Invalid date format.";
                return;
            }

            // Basic validation
            if (!empty($fname) && !empty($lname) && !empty($specialty) && !empty($available_times)) {
                $doctorModel = new Doctor();

                // Pass date as DateTime object or format it for database compatibility
                $result = $doctorModel->addDoctor($fname, $lname, $specialty, $available_times, $birthDateObj->format('Y-m-d'));

                if ($result) {
                    header('Location: index.php?view=doctor&action=listDoctors');
                    exit();
                } else {
                    echo "Error: Unable to add doctor. Please try again.";
                }
            } else {
                echo "Error: All fields are required.";
            }
        }
    }
}
