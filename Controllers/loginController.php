<?php
require_once 'DoctorController.php';
require_once 'DonorController.php';
require_once 'PatientController.php';

class LoginController
{
    public function logMessage(string $message): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['logs'])) {
            $_SESSION['logs'] = [];
        }
        $_SESSION['logs'][] = $message;
    }

    public function getLogs(): array {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION['logs'] ?? [];
    }

    public function clearLogs(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['logs'] = [];
    }
    public function index($action = null)
    {
        switch ($action) {
            case 'processLogin':
                $this->processLogin();
                break;
            default:
                $this->showLoginForm();
                break;
        }
    }

    private function showLoginForm()
    {
        $logs = $this->getLogs(); // Retrieve logs to display in the view
        include '../views/loginView.php';
    }

    private function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = strtolower($_POST['role'] ?? '');

            $this->logMessage("Login attempt for email: $email, role: $role");

            switch ($role) {
                case 'doctor':
                    $controller = new DoctorController();
                    break;
                case 'donor':
                    $controller = new DonorController();
                    break;
                case 'patient':
                    $controller = new PatientController();
                    break;
                default:
                    $this->logMessage("Error: Invalid role selected.");
                    $this->showLoginForm();
                    return;
            }

            try {
                $controller->Login($email, $password, $role);
                $this->logMessage("Login successful for email: $email, role: $role");
//                if($role=='doctor'){
//                    header("Location: index.php?view=$role&action=listDoctors");
//                }elseif($role=='patient'){
//                    header("Location: index.php?view=$role&action=listPatients");
//                }else{
//                    header("Location: index.php?view=$role&action=listDonors");
//                }

                exit;
            } catch (Exception $e) {
                $this->logMessage("Login failed: " . $e->getMessage());
                $this->showLoginForm();
            }
        } else {
            $this->showLoginForm();
        }
    }
}
