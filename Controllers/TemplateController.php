
<?php
require_once 'ProxyController.php';
abstract class TemplateController {
   
	public final function Login($email, $password,$role) {
        $user = $this->getUserByEmail($email);

        if ($this->isValidPassword($password, $user['password'])) {
            // $this->startSession($user,$role);

            // Use the proxy to handle redirection
            $proxy = new ProxyController();
            $proxy->redirectBasedOnRole($role);


            // redirectBasedOnRole function should be in each doctor, donor, patient controller
            // $this->redirectBasedOnRole($role);
            // header("Location: ../Views/logoutView.php");

            print("logged in successfully");
        } else {
            // $this->handleInvalidLogin();
            print("error in logging in");
        }
    }

    // Hook method to get user by email, to be implemented by subclasses
    protected abstract function getUserByEmail($email);

    //abstract method to be overriden in each class (Doctor, Donor, Patient)

    // Validates the password
    private function isValidPassword($password, $hashedpassword) {
        print($hashedpassword);
        return password_verify($password, $hashedpassword);
    }

    // Starts a session for the logged-in user
    private function startSession($user,$role) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
    }

    // Hook method to redirect the user based on their role
    // protected abstract function redirectBasedOnRole($user);

    // Handle invalid login attempt
    private function handleInvalidLogin() {
        session_start();
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: ../Views/loginView.php");
        exit;
    }
}