<?php

require_once __DIR__ . '/../models/doctorModel.php';
require_once 'TemplateController.php';

class DoctorController extends TemplateController implements IRedirect
{
    public function index($action = null)
    {
        switch ($action) {
            case 'listDoctors':
                $this->listDoctors();
                break;
            case 'showAddDoctorForm':
                $this->showAddDoctorForm();
                break;
            case 'addDoctor':
                $this->addDoctor();
                break;
            case 'viewDoctorDetails':
                $this->viewDoctorDetails();
                break;
            default:
                echo "Error: Action not recognized.";
                break;
        }
    }

    protected function getUserByEmail($email) {
        return Person::getUserByEmail($email);
    }

    private function listDoctors() {
        $doctors = Doctor::get_all_doctors_details();
    
        foreach ($doctors as $doctor) {
            // Update applications for each doctor using the observer pattern
            $doctor->update_obeserver();
    
            // Debugging log
            error_log("Doctor ID {$doctor->getId()} has " . count($doctor->getApplications()) . " applications.");
        }
    
        if (empty($doctors)) {
            //echo "Debug: No doctors found in listDoctors() controller method.";
        } else {
            //echo "Debug: Found " . count($doctors) . " doctors in listDoctors() controller method.";
        }
    
        include '../views/doctorView.php';
    }
    
    

    private function showAddDoctorForm()
    {   $ranks = DoctorRank::getAllRanks(); // Fetch all ranks
        $specialties = Speciality::getAllSpecialties(); // Fetch all specialties
        include '../views/doctorAddView.php';
    }

    private function addDoctor()
    {
        $ranks = DoctorRank::getAllRanks(); // Fetch all ranks
        $specialties = Speciality::getAllSpecialties(); // Fetch all specialties
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctor_first_name = $_POST['doctor_first_name'] ?? '';
            $doctor_last_name = $_POST['doctor_last_name'] ?? '';
            $doctor_birth_date = DateTime::createFromFormat('Y-m-d', $_POST['doctor_birth_date'] ?? '');
            $doctor_address_id = (int)($_POST['doctor_address_id'] ?? 0);
    
            $doctor_rank_id = $_POST['doctor_rank_id'] ?? '';
            $doctor_speciality_id = $_POST['doctor_speciality_id'] ?? '';
    
            // Validate rank and specialty IDs
            if (!array_key_exists($doctor_rank_id, $ranks) || !array_key_exists($doctor_speciality_id, $specialties)) {
                echo "Error: Invalid rank or specialty selected.";
                return;
            }
    
            $result = Doctor::add_doctor(
                $doctor_first_name,
                $doctor_last_name,
                $doctor_birth_date,
                $doctor_address_id,
                (int)$doctor_rank_id,
                (int)$doctor_speciality_id
            );
    
            if ($result) {
                header('Location: index.php?view=doctor&action=listDoctors');
                exit();
            } else {
                echo "Error: Unable to add doctor. Please try again.";
            }
        } else {
            $this->showAddDoctorForm();
        }
    }
    private function viewDoctorDetails()
    {
        $doctor_id = $_GET['doctor_id'] ?? 0;
        $doctor = Doctor::getby_id((int)$doctor_id);

        if ($doctor) {
            include '../views/doctorDetailView.php';
        } else {
            echo "Error: Doctor not found.";
        }
    }

    function redirectBasedOnRole($role)
    {
        header("Location: index.php?view=$role&action=listDoctors");
    }
}
