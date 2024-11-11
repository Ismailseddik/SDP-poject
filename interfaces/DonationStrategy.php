<?php
// DonationStrategy.php
interface DonationStrategy
{
    public function donate(float $amount, Donor $donor): void;
}
