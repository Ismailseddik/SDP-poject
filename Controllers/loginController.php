<?php
require_once 'DonorController.php';
require_once 'DoctorController.php';
require_once 'PatientController.php';

$userData = $_POST;
$role = $userData['role'];

switch ($role) {
    case 'donor':
        $controller = new DonorController();
        break;
    case 'doctor':
        $controller = new DoctorController();
        break;
    case 'patient':
        $controller = new PatientController();
        break;
    default:
        throw new Exception("Invalid role selected.");
}


$controller->Login($userData['email'],$userData['password'],$role);