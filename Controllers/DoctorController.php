<?php

require_once __DIR__ . '/../models/doctorModel.php';

class DoctorController
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

    private function listDoctors()
    {
        $doctors = Doctor::get_all_doctors_details();
        if (empty($doctors)) {
            echo "Debug: No doctors found in listDoctors() controller method.";
        } else {
            echo "Debug: Found " . count($doctors) . " doctors in listDoctors() controller method.";
        }
        include '../views/doctorView.php';
    }

    private function showAddDoctorForm()
    {
        include '../views/doctorAddView.php';
    }

    private function addDoctor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctor_first_name = $_POST['doctor_first_name'] ?? '';
            $doctor_last_name = $_POST['doctor_last_name'] ?? '';
            $doctor_birth_date = DateTime::createFromFormat('Y-m-d', $_POST['doctor_birth_date'] ?? '');
            $doctor_address_id = (int)($_POST['doctor_address_id'] ?? 0);
            $doctor_rank_name = $_POST['doctor_rank_name'] ?? '';
            $doctor_speciality_name = $_POST['doctor_speciality_name'] ?? '';

            $result = Doctor::add_doctor(
                $doctor_first_name,
                $doctor_last_name,
                $doctor_birth_date,
                $doctor_address_id,
                $doctor_rank_name,
                $doctor_speciality_name
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
}
