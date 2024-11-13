<?php
// /strategies/OrganDonation.php

class OrganDonation implements DonationStrategy
{
    public function donate(float $amount, Donor $donor): void
    {
        echo "Registering an organ donation for " . $donor->getFirstName() . "\n";
        // Additional logic for processing organ donation
    }
}
