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
            $donationType = $_POST['donation_type'] ?? 'monetary';


            if ($donationType === 'Monetary') {
                $donation_type_id=1;
            } elseif ($donationType === 'Organ') {
                $donation_type_id=2;
            } else {
                echo "Invalid donation type.";
                return;
            }
            // Call the addDonor method from Donor model to save the new donor
            $result = Donor::addDonor($firstName, $lastName,$amount, $donor_birth_date, $donation_type_id);
            
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
        $donations =DonationModel::get_all_donations();
        echo $donations[1]->getDonationId();
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
            $donationId = (int)$_POST['donation_id'] ?? 0;
            $amount = (float)($_POST['amount'] ?? 0);

            // Fetch the donor by ID
            $donor = Donor::getby_id($donorId);
//            $donationId = DonationModel::get_donation_details();
            $donationTypeId=NULL;
            if ($donor) {
                // Choose the appropriate strategy
                if ($donationType === 'Monetary') {
                    $donationTypeId=1;
                    $donationStrategy = new MonetaryDonation();
                } elseif ($donationType === 'Organ'){
                    $donationTypeId=2;
                    $donationStrategy = new OrganDonation();
                } else {
                    echo "Invalid donation type.";
                    return;
                }
                //$donationStrategy = ($donationType === 'organ') ? new OrganDonation() : new MonetaryDonation();

                //$donor->setAmount($donor->getAmount() - $amount); //To be implemented in model
                // Set the strategy and execute donation
                $donor->setDonationStrategy($donationStrategy);

                $donor->donate($donationId,$amount);
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
