<?php

class DonationModel{

    private ?int $id;
    private ?float $amount;
    private ?int $donation_type_id;
    private ?DateTime $donation_date;
    private ?int $aid_type_id;

    
    public function __construct(array $data) {

        $this->id = $data['id'];
        $this->amount = $data['amount'];
        $this->donation_type_id =$data['donation_type_id'];
        $this->donation_date = isset($data['donation_date']) ? new DateTime($data['donation_date']) : null;
        //$this->aid_type_id = $data['aid_type_id'];
    }

    public static function get_donation_details(int $donation_id): DonationModel|bool
    {
        $query = "
            SELECT 
            *    
            FROM donation
            WHERE donation.id = $donation_id
        ";

        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            echo "Error: Donation with ID $donation_id not found.";
            return false;
        }
    }

    public static function add_donation($amount): bool
    {
    $query = "INSERT INTO donation (amount, donation_type_id, donation_date) VALUES ($amount, 1, NOW())";
    
    return run_query($query, true);
    }

    
    public static function update_donation($amount,$donation_id): bool
    {
    $query =  $query = "UPDATE `donation` SET amount = '$amount' WHERE id = '$donation_id' ";
    
    return run_query($query, true);
    }
    
        


}