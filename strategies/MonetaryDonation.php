<?php
// /strategies/MonetaryDonation.php
require_once '../interfaces/DonationStrategy.php';

class MonetaryDonation implements DonationStrategy
{
    public function donate(float $amount, Donor $donor, int $donation_id): void
    {
        // Save monetary donation to the database
        $donationSuccess = DonationModel::update_donation($amount,$donation_id);
        if ($donationSuccess) {
            echo "Monetary donation of $" . $amount . " recorded for donor " . $donor->getFirstName() . ".";
        } else {
            echo "Failed to process monetary donation for donor " . $donor->getFirstName() . ".";
        }
    }
}
