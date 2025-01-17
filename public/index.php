<?php
require_once '../config.php';

// Get 'view' and 'action' parameters from the URL, if presentz
$view = $_GET['view'] ?? 'login';
$action = $_GET['action'] ?? null;

// Dynamically set defaults based on view
switch ($view) {
    case 'login':
        require '../controllers/LoginController.php';
        $controller = new LoginController();
        $action = $action ?? 'showLoginForm';
        break;

    case 'doctor':
        require '../controllers/DoctorController.php';
        $controller = new DoctorController();
        $action = $action ?? 'listDoctors'; // Default action for doctors
        break;

    case 'donor':
        require '../controllers/DonorController.php';
        $controller = new DonorController();
        $action = $action ?? 'listDonors'; // Default action for donors
        break;

    case 'donation':
        require '../controllers/DonationController.php';
        $controller = new DonationController(); //
        $action = $action ?? 'listDonations'; // Default action for donations
        break;

    case 'aidType':
        require '../controllers/AidTypeController.php';
        $controller = new AidTypeController();
        $action = $action ?? 'listAidTypes'; // Default action for aid types
        break;

    case 'medicalApplication':
        require '../controllers/MedicalApplicationController.php';
        $controller = new MedicalApplicationController();
        $action = $action ?? 'listApplications'; // Default action for medical applications
        break;

    case 'patient':
        require '../controllers/PatientController.php';
        $controller = new PatientController();
        $action = $action ?? 'listPatients'; // Default action for patients
        break;

    default:
        echo "Error: View not recognized.";
        exit;
}

// Call the controller's index method with the action
$controller->index($action);
