<?php

class DonationModel{

    private ?int $id;
    private ?float $amount;
    private ?int $donation_type_id;
    private ?DateTime $donation_date;
    private ?String $organ;
    private ?int $aid_type_id;
    
    public function __construct(array $data) {

        $this->id = $data['id'];
        $this->amount = $data['amount'];
        $this->donation_type_id =$data['donation_type_id'];
        $this->donation_date = isset($data['donation_date']) ? new DateTime($data['donation_date']) : null;
        $this->organ = $data['organ'];
        //$this->aid_type_id = $data['aid_type_id'];
    }

    public function getDonationId(): int|null { return $this->id;}
    public function getAmount(): float|null { return $this->amount; }
    public function getDonationTypeId(): int|null { return $this->donation_type_id; }
    public function getDonationDate(): DateTime|null { return $this->donation_date; }
    public function getOrgan(): String|null { return $this->organ; }

    public static function get_donation_details(int $donation_id): DonationModel|bool
    {
        $query = "
            SELECT 
                donation.id,
                donation.amount,
                donation.donation_type_id,
                donation_type.donation_type,
                donation.donation_date,
                donation.organ
            FROM donation 
            JOIN donation_type ON donation.donation_type_id = donation_type.id
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
    public static function get_all_donations(): array
    {
        $query = "
            SELECT 
                donation.id,
                donation.amount,
                donation.donation_type_id,
                donation_type.donation_type,
                donation.donation_date,
                donation.organ
            FROM donation 
            JOIN donation_type ON donation.donation_type_id = donation_type.id
        ";
        $donations = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $donations[] = new DonationModel($row);
            }
        }

        return $donations;
    }


    public static function add_donation(?int $amount = null, int $donation_type_id, ?string $organ = null): bool
    { 
        
        $query = "";
    
        if ($amount !== null) {
            $query = "INSERT INTO donation (amount, donation_type_id, donation_date, organ) VALUES ($amount, $donation_type_id, NOW(), NULL)";
        } else if($organ !==null){
            
            $query = "INSERT INTO donation (amount, donation_type_id, donation_date, organ) VALUES (NULL, $donation_type_id, NOW(), '$organ')";
        }
    
        return run_query($query, true);
    }
    
    public static function update_donation($amount,$donation_id,$organ): bool
    {
        if ($organ != NULL)
        {
            $query =  $query = "UPDATE `donation` SET organ = '$organ' WHERE id = '$donation_id' ";
        }
        else {
            $query =  $query = "UPDATE `donation` SET amount = '$amount' WHERE id = '$donation_id' ";
        }
    return run_query($query, true);
    }
    
    public static function delete($donation_id): bool
    {
        $query = "DELETE FROM `donation` WHERE id = '$donation_id'";
    return run_query($query, true);
    }


}