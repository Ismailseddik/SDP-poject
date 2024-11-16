<?php
// DonorController.php
require_once '../models/donorModel.php';
require_once '../strategies/MonetaryDonation.php';
require_once '../strategies/OrganDonation.php';

class DonorController
{
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
            default:
                echo "Error: Action not recognized in DonorController.";
                break;
        }
    }
    private function addDonor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstName = $_POST['donor_first_name'] ?? '';
            $lastName = $_POST['donor_last_name'] ?? '';
            $donor_birth_date = DateTime::createFromFormat('Y-m-d', $_POST['donor_birth_date'] ?? '');
            // $email = $_POST['donor_email'] ?? '';
            $amount = (float)($_POST['donor_amount'] ?? 0);

            // Call the addDonor method from Donor model to save the new donor
            $result = Donor::addDonor($firstName, $lastName,$amount, $donor_birth_date);
            
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
        //
        //error_log(print_r($donors, true)); // Logs the array in your PHP error log
        include '../views/donorView.php';
    }
    private function showAddDonorForm(): void
    {
        include '../views/donorAddView.php';
    }
    // Method to show the add donation form
    private function showAddDonationForm(): void
    {
        $donors = Donor::getAllDonors();
        //echo $donors[0]->getFirstName();
        include '../views/showAddDonationForm.php';
    }

    // Method to handle form submission and add a new donation
    private function addDonation(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get donor ID, donation type, and amount from form
            $donorId = (int)$_POST['donor_id'] ?? 0;
            $donationType = $_POST['donation_type'] ?? 'monetary';
            $amount = (float)($_POST['donor_amount'] ?? 0);

            // Fetch the donor by ID
            $donor = Donor::getby_id($donorId);

            if ($donor) {
                // Choose the appropriate strategy
                $donationStrategy = ($donationType === 'organ') ? new OrganDonation() : new MonetaryDonation();

                //$donor->setAmount($donor->getAmount() - $amount); //To be implemented in model
                // Set the strategy and execute donation
                $donor->setDonationStrategy($donationStrategy);
                $donor->donate($amount);

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
