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
        $this->donation_date = $data['donation_date'];
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

}