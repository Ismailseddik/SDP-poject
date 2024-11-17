<?php
// /strategies/OrganDonation.php

class OrganDonation implements DonationStrategy
{
    public function donate(float $amount, Donor $donor, int $donation_id): void
    {
        echo "Registering an organ donation for " . $donor->getFirstName() . "\n";

        // Save monetary donation to the database
        $donationSuccess = DonationModel::update_donation($amount,$donation_id);
        if ($donationSuccess) {
            echo "Monetary donation of $" . $amount . " recorded for donor " . $donor->getFirstName() . ".";
        } else {
            echo "Failed to process monetary donation for donor " . $donor->getFirstName() . ".";
        }

        // Additional logic for processing organ donation
        //In donationModel we still have no function specific to deal with organs
    }
}
