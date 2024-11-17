<?php
// DonationStrategy.php
interface DonationStrategy
{
    public function donate(Donor $donor, int $donation_id,float $amount=NULL, String $organ=NULL): void;
}
