
<?php
abstract class TemplateController {
   
	public final function Login($email, $password,$role) {
        $user = $this->getUserByEmail($email);

        if ($this->isValidPassword($password, $user['password'])) {
            // $this->startSession($user,$role);
            // $this->redirectBasedOnRole($user);
            // header("Location: ../Views/logoutView.php");
            header("Location: ../public/index.php");
            print("logged in successfully");
        } else {
            // $this->handleInvalidLogin();
            print("error in logging in");
        }
    }

    // Hook method to get user by email, to be implemented by subclasses
    protected abstract function getUserByEmail($email);

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