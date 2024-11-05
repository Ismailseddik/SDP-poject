<?php
require_once '../config.php';

// Simple routing based on query parameters 'view' and 'action'
$view = $_GET['view'] ?? 'patient'; // Default to 'patient' view
$action = $_GET['action'] ?? 'list'; // Default action to 'list' for all controllers

switch ($view) {
    case 'doctor':
        require '../controllers/DoctorController.php';
        $doctorController = new DoctorController();
        $doctorController->index($action); // Pass the action parameter to DoctorController's index
        break;

    case 'donor':
        require '../controllers/DonorController.php';
        $donorController = new DonorController();
        $donorController->index($action); // Pass the action parameter to DonorController's index
        break;

    case 'donation':
        require '../controllers/DonationController.php';
        $donationController = new DonationController();
        $donationController->index($action); // Pass the action parameter to DonationController's index
        break;

    case 'aidType':
        require '../controllers/AidTypeController.php';
        $aidTypeController = new AidTypeController();
        $aidTypeController->index($action); // Pass the action parameter to AidTypeController's index
        break;

    case 'medicalApplication':
        require '../controllers/MedicalApplicationController.php';
        $medicalApplicationController = new MedicalApplicationController();
        $medicalApplicationController->index($action); // Pass the action parameter to MedicalApplicationController's index
        break;

    default:
        require '../controllers/PatientController.php';
        $patientController = new PatientController();
        $patientController->index($action); // Pass the action parameter to PatientController's index
}
