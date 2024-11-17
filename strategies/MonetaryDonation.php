<?php
// /strategies/MonetaryDonation.php
require_once '../interfaces/DonationStrategy.php';

class MonetaryDonation implements DonationStrategy
{
    public function donate(Donor $donor, int $donation_id,float $amount=NULL, String $organ=NULL): void
    {
        // Save monetary donation to the database
        $donationSuccess = DonationModel::update_donation($amount,$donation_id,NULL);
        if ($donationSuccess) {
            echo "Monetary donation of $" . $amount . " recorded for donor " . $donor->getFirstName() . ".";
        } else {
            echo "Failed to process monetary donation for donor " . $donor->getFirstName() . ".";
        }
    }
}
