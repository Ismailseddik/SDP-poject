<?php
// DonorController.php
require_once '../models/donorModel.php';
require_once '../strategies/MonetaryDonation.php';
require_once '../strategies/OrganDonation.php';
require_once 'TemplateController.php';
require_once '../Adapter/IPayment.php';
require_once '../Adapter/CreditAdapter.php';
require_once '../Adapter/PaypalAdapter.php';
$baseDir = realpath(__DIR__ . '/../States') . DIRECTORY_SEPARATOR;
require_once $baseDir . 'InitializePaymentState.php';
require_once $baseDir . 'ProcessPaymentState.php';
require_once $baseDir . 'ReceiveResponseState.php';
require_once $baseDir . 'DisplayResponseState.php';
require_once $baseDir . 'FinalState.php';


class DonorController extends TemplateController
{
    private $currentState;
    private $logs = [];
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
    
    public function setState(IPaymentState $state): void {
        $this->currentState = $state;
    }

    public function getState(): IPaymentState {
        return $this->currentState;
    }
    // Example of how to transition through states
    public function handleTransition(string $transition, array $data = []): void {
        if (method_exists($this->currentState, $transition)) {
            $this->currentState->{$transition}($data);
        } else {
            echo "Invalid transition: $transition";
        }
    }
    public function index($action = null): void
    {
        switch ($action) {
            case 'listDonors':
                $this->listDonors();
                break;
            case 'showAddDonationForm':
                $this->showAddDonationForm();
                break;
            case 'addDonation':
                $this->addDonation();
                break;
            case 'donorAddView':
                 $this->showAddDonorForm();
                break;
            case 'addDonor':
                 $this->addDonor();
                 break;
            case 'paymentType':
                 $this->paymentType();
                 break;
            default:
                echo "Error: Action not recognized in DonorController.";
                break;
        }
    }


    private function paymentType():void{
        $userData = $_POST;
        $paymentType = $userData['paymentType'];

        switch ($paymentType) {
            case 'Paypal':
                // $ = new CreditAdapter(new );
                break;
            case 'Credit':
                $controller = new DoctorController();
                break;
            default:
                throw new Exception("Invalid role selected.");
}
    }
    private function addDonor(): void
    {
        $workflowCompleted = false; // Flag to track if workflow completed
        $errorMessage = ""; // Store any error message for rendering
        $successMessage = ""; // Store any success message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstName = $_POST['donor_first_name'] ?? '';
            $lastName = $_POST['donor_last_name'] ?? '';
            $donor_birth_date = DateTime::createFromFormat('Y-m-d', $_POST['donor_birth_date'] ?? '');
            // $email = $_POST['donor_email'] ?? '';
            $amount = (float)($_POST['donor_amount'] ?? NULL);
            $organ = $_POST['organ'] ?? '';
            $donationType = $_POST['donation_type'] ?? 'monetary';
            // Initialize payment
            $this->setState(new InitializePaymentState($this));
            $this->handleTransition('ReceiveData', $_POST);
            // Check if the transaction reached the FinalState
            if ($this->getState() instanceof FinalState) {
                $workflowCompleted = true; // Indicate success
                $successMessage = "Transaction completed successfully.";
                $this->logMessage($successMessage);
            } else {
                $errorMessage = "Transaction failed or still in progress.";
                $this->logMessage($errorMessage);
                    // Fetch donors and donations for the view
                $donors = Donor::getAllDonors();
                $donations = DonationModel::get_all_donations();
                $logs = $this->getLogs();
                $this->clearLogs(); // Clear logs after rendering

                // Include the view, passing necessary variables
                include '../views/donorView.php';
                return;
            }
            if ($amount==0){
                $amount=NULL;
            }
            if ($donationType === 'Monetary') {
                $donation_type_id=1;
            } elseif ($donationType === 'Organ') {
                $donation_type_id=2;
            } else {
                echo "Invalid donation type.";
                return;
            }
            // Call the addDonor method from Donor model to save the new donor
            $result = Donor::addDonor($firstName, $lastName,$amount, $donor_birth_date,$organ, $donation_type_id);

            if ($result) {
                // Redirect to donor list after successful addition
                header('Location: index.php?view=donor&action=listDonors');
                exit();
            } else {
                echo "Error: Unable to add donor. Please try again.";
            }
        } else {
            $this->showAddDonorForm();
        }
    }
    // Method to list donors
    private function listDonors(): void
    {
        $donors = Donor::getAllDonors();
        $donations =DonationModel::get_all_donations();
        //
        //error_log(print_r($donors, true)); // Logs the array in your PHP error log
        $logs = $this->getLogs();
        $this->clearLogs();
        include '../views/donorView.php';
    }

    protected function getUserByEmail($email) {
        return Person::getUserByEmail($email);
    }
    private function showAddDonorForm(): void
    {
        include '../views/donorAddView.php';
    }
    // Method to show the add donation form
    private function showAddDonationForm(): void
    {
        $donors = Donor::getAllDonors();
        $donations =DonationModel::get_all_donations();
       // echo $donations[1]->getDonationId();
        //echo $donors[0]->getFirstName();
        include '../views/showAddDonationForm.php';
    }

    // Method to handle form submission and add a new donation
    private function addDonation(): void
    {
        $workflowCompleted = false; // Flag to track if workflow completed
        $errorMessage = ""; // Store any error message for rendering
        $successMessage = ""; // Store any success message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get donor ID, donation type, and amount from form
            $donorId = (int)$_POST['donor_id'] ?? 0;
            $donationType = $_POST['donation_type'] ?? 'monetary';
            $donationId = (int)$_POST['donation_id'] ?? 0;
            $amount = (float)($_POST['amount'] ?? 0);
            $organ = $_POST['organ'] ?? '';
            $this->setState(new InitializePaymentState($this));
            $this->handleTransition('ReceiveData', $_POST);
            // Check if the transaction reached the FinalState
            if ($this->getState() instanceof FinalState) {
                $workflowCompleted = true; // Indicate success
                $successMessage = "Transaction completed successfully.";
                $this->logMessage($successMessage);
            } else {
                $errorMessage = "Transaction failed or still in progress.";
                $this->logMessage($errorMessage);
                    // Fetch donors and donations for the view
                $donors = Donor::getAllDonors();
                $donations = DonationModel::get_all_donations();
                $logs = $this->getLogs();
                $this->clearLogs(); // Clear logs after rendering

                // Include the view, passing necessary variables
                include '../views/donorView.php';
                return;
            }
            // Fetch the donor by ID
            $donor = Donor::getby_id($donorId);
//            $donationId = DonationModel::get_donation_details();
            $donationTypeId=NULL;
            if ($donor) {
                // Choose the appropriate strategy
                if ($donationType === 'Monetary') {
                    $donationTypeId=1;
                    $donationStrategy = new MonetaryDonation();
                    $donor->setDonationStrategy($donationStrategy);
                    $donor->donate($donationId,$amount,NULL);
                } elseif ($donationType === 'Organ'){
                    $donationTypeId=2;
                    $donationStrategy = new OrganDonation();
                    $donor->setDonationStrategy($donationStrategy);
                    $donor->donate($donationId,NULL,$organ);
                } else {
                    echo "Invalid donation type.";
                    return;
                }
                //$donationStrategy = ($donationType === 'organ') ? new OrganDonation() : new MonetaryDonation();

                //$donor->setAmount($donor->getAmount() - $amount); //To be implemented in model
                // Set the strategy and execute donation

                //Moved UP
                //$donor->setDonationStrategy($donationStrategy);
                //$donor->donate($donationId,$amount,$organ);


                //DonationModel::update_donation($amount,1);


                // Redirect to donor list after donation
                header('Location: index.php?view=donor&action=listDonors');
                exit();
            } else {
                echo "Error: Donor not found.";
            }
        } else {
            // If not a POST request, show the add donation form
            $this->showAddDonationForm();
        }
    }
}
