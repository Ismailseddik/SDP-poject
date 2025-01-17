<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
// require_once '../strategies/MonetaryDonation.php';
// require_once '../strategies/OrganDonation.php';
require_once "personModel.php";
require_once "donorModel.php";
require_once "donationModel.php";
require_once "donorDonationModel.php";

class Donor extends Person
{
   
    private ?int $person_id;
    private ?float $amount;
    private ?String $tier;
    private ?String $organ;
    private DonationStrategy $donationStrategy;
    private DonorTierStrategy $tierStrategy;


    public function __construct(array $data, DonorTierStrategy $tierStrategy = null)
    {
        $this->id = $data['id'] ?? null;
        $this->person_id = $data['person_id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->organ = $data['organ'] ?? null;
        if ($tierStrategy) {
            $this->tierStrategy = $tierStrategy;
        }

        $this->tier = $data['tier'] ?? null;
    }

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->first_name <br/>";
        $str .= "Last Name: $this->last_name<br/>";
        $str .= "Amount: $this->amount<br/>";
        $str .= "Organ: $this->organ<br/>";
        $str .= "Tier: $this->tier<br/>";

        return $str . '</pre>';
    }

    
    public function getFirstName(): string|null { return $this->first_name; }
    public function getPersonId(): int|null { return $this->person_id;}

    public function getLastName(): string|null { return $this->last_name; }
    public function getAmount(): float|null { return $this->amount; }
    public function getOrgan(): float|null { return $this->organ; }

    //*************** tiers ****************
    // Change donor tier dynamically
//    public function setTier(DonorTierStrategy $tierStrategy)
//    {
//        $this->tierStrategy = $tierStrategy;
//    }
//
//    public function getTierBenefits(): string
//    {
//        return $this->tierStrategy->getBenefits();
//    }
//
//    public function getDiscountRate(): float
//    {
//        return $this->tierStrategy->getDiscountRate();
//    }
//
//    public function getTierName(): string
//    {
//        return $this->tierStrategy->getTierName();
//    }
//
//    public function getDonorInfo(): string
//    {
//        return "Donor Name: {$this->first_name}, Tier: {$this->getTierName()}, Benefits: {$this->getTierBenefits()}";
//    }
    //*************** end of tiers ****************


    // Set the donation strategy
     public function setDonationStrategy(DonationStrategy $donationStrategy): void
     {
         $this->donationStrategy = $donationStrategy;
     }

     //Execute donation using the current strategy
     public function donate(int $donation_id, float $donation_amount=NULL, String $organ=NULL): void
     {
         $this->donationStrategy->donate($this,$donation_id,$donation_amount!=NULL?($this->amount+$donation_amount):NULL,$organ);
     }


    public static function getby_id($donor_id): Donor|bool
    {
        $query = "
            SELECT 
                donor.id, 
                donor.person_id, 
                person.first_name, 
                person.last_name, 
                donation.amount,
                donation.organ, 
                donor_tier.tier
            FROM donor
            JOIN person ON donor.person_id = person.id
            JOIN donor_tier ON donor.tier_id = donor_tier.id
            JOIN donor_donation ON donor.id = donor_donation.donor_id
            JOIN donation ON donor_donation.donation_id = donation.id
            WHERE donor.id = $donor_id
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
            SELECT 
                donor.id, 
                donor.person_id, 
                person.first_name, 
                person.last_name, 
                donation.amount, 
                donation.organ,
                donor_tier.tier
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

   
    public static function addDonor(
    string $first_name,
    string $last_name, 
    ?float $amount = null,
    DateTime $donor_birth_date,
    ?String $organ = null,
    int $donation_type_id): bool
    {
        $conn=DataBase::getInstance()->getConn();

        $person_state = Person::add_person($first_name,$last_name, $donor_birth_date, 1);
        // Insert into person table first
        if (!$person_state) {
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
        $donation_state = DonationModel::add_donation($amount,$donation_type_id,$organ);
        if (!$donation_state) {
            echo "Error: Failed to add donation record.";
            return false;
        }

        // Get the new donation_id
        $donation_id = $conn->insert_id;

        
        // Link donation to donor in donor_donation table
        $donor_donation_state = DonorDonation::add_donor_donation($donation_id,$donor_id);
        if (!$donor_donation_state ){
            echo "Error: Failed to link donation to donor.";
            return false;
        }

        return true;
    }

    public static function update(array $array): bool {
        
        if (!isset($array['donor_id'])) {
            echo "Error: 'id' is required to update a doctor.";
            return false;
        }
        
        $id = $array['donor_id'];
      
        if (isset($array['tier_id'])) {
            $setParts[] = "`tier_id` = " . intval($array['tier_id']);
        }
        
        if (empty($setParts)) {
            echo "Error: No fields to update.";
            return false;
        }

        $setClause = implode(', ', $setParts);
        
        $query = "UPDATE `donor` SET $setClause WHERE id = '$id'";

        $status = run_query($query, true);
        Person::update($array);
        return $status;
    }
    public static function delete($id): bool {
       
        $query = "UPDATE `person` SET `isDeleted` = 1 WHERE id = '$id'";//person_id for donor

        return run_query($query, true);
    }
}
