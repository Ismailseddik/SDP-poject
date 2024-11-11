<?php
// DonorController.php
require_once '../models/donorModel.php';
require_once '../strategies/MonetaryDonation.php';
require_once '../strategies/OrganDonation.php';

class DonorController
{
    public function index($action = null)
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
    private function addDonor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstName = $_POST['donor_first_name'] ?? '';
            $lastName = $_POST['donor_last_name'] ?? '';
            $email = $_POST['donor_email'] ?? '';
            $amount = (float)($_POST['donor_amount'] ?? 0);

            // Call the addDonor method from Donor model to save the new donor
            $result = Donor::addDonor($firstName, $lastName, $email, $amount);

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
    private function listDonors()
    {
        $donors = Donor::getAllDonors();
        include '../views/donorView.php';
    }
    private function showAddDonorForm(){
        include '../views/donorAddView.php';
    }
    // Method to show the add donation form
    private function showAddDonationForm()
    {
        include '../views/showAddDonationForm.php';
    }

    // Method to handle form submission and add a new donation
    private function addDonation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get donation type and amount from form
            $donationType = $_POST['donation_type'] ?? 'monetary';
            $amount = (float)($_POST['donor_amount'] ?? 0);

            // Choose the appropriate strategy based on donation type
            $donationStrategy = ($donationType === 'organ') ? new OrganDonation() : new MonetaryDonation();

            // Gather donor data from the form
            $donorData = [
                'first_name' => $_POST['donor_first_name'],
                'last_name' => $_POST['donor_last_name'],
                'email' => $_POST['donor_email'],
                'amount' => $amount
            ];

            // Create a new Donor object with the selected strategy
            $donor = new Donor($donorData, $donationStrategy);
            $donor->donate();  // Execute the donation using the chosen strategy

            // Redirect to the donor list after donation
            header('Location: index.php?view=donor&action=listDonors');
            exit();
        } else {
            // If not a POST request, show the add donation form
            $this->showAddDonationForm();
        }
    }
}
