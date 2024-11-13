<?php
// /strategies/MonetaryDonation.php

class MonetaryDonation implements DonationStrategy
{
    public function donate(float $amount, Donor $donor): void
    {
        echo "Processing a monetary donation of $" . $amount . " for " . $donor->getFirstName() . "\n";
        // Additional logic for processing monetary donation
    }
}
