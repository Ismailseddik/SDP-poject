<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class DonorDonation{

    private ?int $id;
    private ?int $donation_id;
    private ?float $donation_amount;
    private ?String $donation_organ;
    private ?int $donation_type_id;
    private ?String $donor_name;
   
    private ?int $donor_id;

    public function __construct(array $data){
        
      $this->id = $data['donor_donation_id'];
      $this->donation_amount = $data['donation_amount'];
      $this->donation_organ = $data['donation_organ'];
      $this->donation_type_id = $data['donation_type_id'];
      $this->donor_name = $data['first_name'] . ' ' .$data['last_name'];       
        
    }

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Name: $this->donor_name <br/>";
        $str .= "Amount: $this->donation_amount<br/>";
        $str .= "Organ: $this->donation_organ<br/>";
        $str .= "Donation Type Id: $this->donation_type_id<br/>";
    
        return $str . '</pre>';
    }
    public static function get_all_donations_donors(){

        $query = "
        SELECT 
            donor_donation.id AS donor_donation_id, 
            donation.amount AS donation_amount, 
            donation.organ AS donation_organ, 
            donation.donation_type_id,
            donor.person_id, 
            person.first_name, 
            person.last_name
        FROM donor_donation
        JOIN donation ON donor_donation.donation_id = donation.id
        JOIN donor ON donor_donation.donor_id = donor.id
        JOIN person ON donor.person_id = person.id
        JOIN donor_tier ON donor.tier_id = donor_tier.id
        ";
        /* donor_donation_id | donation_id | id | donation_amount | donation_type_id | donation_date |donar_id | id | person_id | first_name | last_name | tier_id */
        $donations = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $donations[] = new DonorDonation($row);
            }
        }

        return $donations;
        

    }

    public static function get_donations_donor($donor_id){

        $query = "
        SELECT 
            donor_donation.id AS donor_donation_id, 
            donation.amount AS donation_amount,
            donation.organ AS donation_organ, 
            donation.donation_type_id, 
            donor.person_id,
            person.first_name, 
            person.last_name
        FROM donor_donation
        JOIN donation ON donor_donation.donation_id = donation.id
        JOIN donor ON donor_donation.donor_id = donor.id
        JOIN person ON donor.person_id = person.id
        JOIN donor_tier ON donor.tier_id = donor_tier.id
        WHERE donor_donation.donor_id = $donor_id
        ";
        /* donor_donation_id | donation_id | id | donation_amount | donation_type_id | donation_date |donar_id | id | person_id | first_name | last_name | tier_id */
        
        $donordonations = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $donordonations[] = new DonorDonation($row);
            }
        }

        return $donordonations;
    }
    
    public static function add_donor_donation($donation_id,$donor_id){
        $query = "INSERT INTO `donor_donation` (donation_id,donor_id)
        VALUES ('$donation_id', '$donor_id')";

        return run_query($query, true);

    }

    public static function update($array): bool
    {   $donation_id = $array['donation_id'];
        $donor_id = $array['donor_id'];
        $donor_donation_id = $array['donor_donation_id'];
        $set_parts = [];
        if ($donor_id !== null) {
    
            $set_parts = "`donor_id` = '" . $donor_id . "'";
        }
        if ($donation_id !== null) {
       
            $set_parts = "`donation_id` = '" . $donation_id . "'";
        }
        
    $query = "UPDATE `donor_donation` SET $set_parts WHERE id = '$donor_donation_id' ";
    return run_query($query, true);
    }

    public static function delete($donor_donation_id): bool{
        
    $query = "DELETE FROM `donor_donation` WHERE id = '$donor_donation_id'";
        return run_query($query, true);

        
    }





}