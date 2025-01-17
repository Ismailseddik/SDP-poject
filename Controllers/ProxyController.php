<?php
require_once '../interfaces/IRedirect.php';
class ProxyController implements IRedirect
{

    public function redirectBasedOnRole($role)
    {
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
        $controller->redirectBasedOnRole($role);
    }
}