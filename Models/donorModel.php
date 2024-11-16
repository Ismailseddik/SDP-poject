<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
// require_once '../strategies/MonetaryDonation.php';
// require_once '../strategies/OrganDonation.php';
require_once "personModel.php";

class Donor extends Person
{
   
    private ?int $person_id;
    private ?float $amount;
    private ?String $tier;
    // private DonationStrategy $donationStrategy;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->person_id = $data['person_id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->tier = $data['tier'] ?? null;
    }

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->first_name <br/>";
        $str .= "Last Name: $this->last_name<br/>";
        $str .= "Amount: $this->amount<br/>";
        $str .= "Tier: $this->tier<br/>";

        return $str . '</pre>';
    }

    
    public function getFirstName(): string|null { return $this->first_name; }
    public function getPersonId(): int|null { return $this->person_id;}

    public function getLastName(): string|null { return $this->last_name; }
    public function getAmount(): float|null { return $this->amount; }

    // Set the donation strategy
    // public function setDonationStrategy(DonationStrategy $donationStrategy): void
    // {
    //     $this->donationStrategy = $donationStrategy;
    // }

    // Execute donation using the current strategy
    // public function donate(): void
    // {
    //     $this->donationStrategy->donate($this->amount, $this);
    // }


    public static function getby_id($donor_id): Donor|bool
    {
        $query = "
            SELECT donor.id, donor.person_id, person.first_name, person.last_name, donation.amount, donor_tier.tier
            FROM donor
            JOIN person ON donor.person_id = person.id
            JOIN donor_tier ON donor.tier_id = donor_tier.id
            JOIN donor_donation ON donor.id = donor_donation.donor_id
            JOIN donation ON donor_donation.donation_id = donation.id
        ";
        
        
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            echo "Error: Donor with ID $donor_id not found.";
            return false;
        }

        
    }

    public static function getAllDonors(): array
    {
        $query = "
            SELECT donor.id, donor.person_id, person.first_name, person.last_name, donation.amount, donor_tier.tier
            FROM donor
            JOIN person ON donor.person_id = person.id
            JOIN donor_tier ON donor.tier_id = donor_tier.id
            JOIN donor_donation ON donor.id = donor_donation.donor_id
            JOIN donation ON donor_donation.donation_id = donation.id
        ";
        
        
        $donors = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $donors[] = new Donor($row);
            }
        }

        return $donors;
    }

   
    public static function addDonor(string $first_name, string $last_name, float $amount): bool
    {
        global $conn;

        // Insert into person table first
        $query_person = "INSERT INTO person (first_name, last_name, birth_date, address_id) VALUES ('$first_name', '$last_name', CURDATE(), 1)";
        if (!run_query($query_person, true)) {
            echo "Error: Failed to add person record.";
            return false;
        }
        
        // Get the new person_id
        $person_id = $conn->insert_id;

        // Insert into donor table with the new person_id
        $query_donor = "INSERT INTO donor (person_id, tier_id) VALUES ($person_id, 1)";
        if (!run_query($query_donor, true)) {
            echo "Error: Failed to add donor record.";
            return false;
        }

        // Get the new donor_id
        $donor_id = $conn->insert_id;

        // Insert donation record and associate with donor
        $query_donation = "INSERT INTO donation (amount, donation_type_id, donation_date) VALUES ($amount, 1, NOW())";
        if (!run_query($query_donation, true)) {
            echo "Error: Failed to add donation record.";
            return false;
        }

        // Get the new donation_id
        $donation_id = $conn->insert_id;

        // Link donation to donor in donor_donation table
        $query_donor_donation = "INSERT INTO donor_donation (donation_id, donor_id) VALUES ($donation_id, $donor_id)";
        if (!run_query($query_donor_donation, true)) {
            echo "Error: Failed to link donation to donor.";
            return false;
        }

        return true;
    }
}
