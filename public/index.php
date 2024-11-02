<?php
require_once '../config.php';

// Simple routing based on query parameter 'view'
$view = $_GET['view'] ?? 'patient'; // Default to 'patient' view

switch ($view) {
    case 'doctor':
        require '../controllers/DoctorController.php';
        (new DoctorController())->index();
        break;
    case 'donor':
        require '../controllers/DonorController.php';
        (new DonorController())->index();
        break;
    case 'donation':
        require '../controllers/DonationController.php';
        (new DonationController())->index();
        break;
    case 'aidType':
        require '../controllers/AidTypeController.php';
        (new AidTypeController())->index();
        break;
    case 'medicalApplication':
        require '../controllers/MedicalApplicationController.php';
        (new MedicalApplicationController())->index();
        break;
    default:
        require '../controllers/PatientController.php';
        (new PatientController())->index();
}
