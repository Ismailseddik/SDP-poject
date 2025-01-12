<?php
ob_start();

include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Models\donationTypeModel");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Models\OrganModel");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Utils\utils.php");
// CRUD
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Create.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Update.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Delete.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Read.php");

ob_end_clean();

class Donation implements Create, Update, Delete, Read
{

    private ?int $id;
    private ?float $amount;
    private ?int $donation_type_id;
    private ?DateTime $donation_date;
    private ?int $organ_id;
    
    public function __construct(array $data) {

        $this->id = $data['id'];
        $this->amount = $data['amount'];
        $this->donation_type_id =$data['donation_type_id'];
        $this->donation_date = isset($data['donation_date']) ? new DateTime($data['donation_date']) : null;
        $this->organ_id = $data['organ_id'];
    }

    public function getId(): int|null        { return $this->id;}
    public function getAmount(): float|null          { return $this->amount; }
    public function getDonationTypeId(): int|null    { return $this->donation_type_id; }
    public function getDonationDate(): DateTime|null { return $this->donation_date; }
    public function getOrganID(): int|null           { return $this->organ_id; }


    public function getDonationType(){return DonationType::Read($this->getDonationTypeId())->get_donation_type();}
    public function getOrganName(){return Organ::Read($this->getOrganID())->get_organ_name();}


    // public function setId($id)                           { if(Donation::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;}}
    public function setAmount($amount)                   { if(Donation::ConditionedUpdate($this->id,'amount',$amount)){$this->amount = $amount;} }
    public function setDonationTypeId($donation_type_id) { if(Donation::ConditionedUpdate($this->id,'donation_type_id',$donation_type_id)){$this->donation_type_id = $donation_type_id;} }
    public function setDonationDate($donation_date)      { if(Donation::ConditionedUpdate($this->id,'donation_date',$donation_date)){$this->donation_date = $donation_date;} }
    public function setOrganID($organ_id)                { if(Donation::ConditionedUpdate($this->id,'organ_id',$organ_id)){$this->organ_id = $organ_id; }}



    public static function Read_All()
    {
        $Donations = []; 
        $rows = run_select_query("SELECT * FROM `donation`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Donations[] = new Donation($row); }
        } 
        else 
        {
            return false;
        }

        return $Donations;
    }
    public static function Read($id)
    {
        $query = "SELECT * FROM `donation` WHERE id = '$id'";

        if (!does_exist($query)){
            return false;
        }
        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());

    }


    public static function Create($array) 
    {
        if (!array_check($array, 4)){
            return false;
        }

        if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$array[1]'")){
            return false;
        }

        if (!does_exist("SELECT * FROM `organ` WHERE id = '$array[3]'")){
            return false;
        }

        $birth_date_formatted = $array[2]->format('Y-m-d');
        $query = "INSERT INTO `donation` (amount, donation_type_id,  donation_date , organ_id)
              VALUES ('$array[0]', '$array[1]',  '$birth_date_formatted' ,'$array[3]')";

        return run_query($query, true);
    }
    
    public static function Update($array)
    {
        if (!array_check($array, 5)){
            return false;
        }
        if (!does_exist("SELECT * FROM `donation` WHERE id = '$array[0]'")){
            return false;
        }

        if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$array[2]'")){
            return false;
        }

        if (!does_exist("SELECT * FROM `organ` WHERE id = '$array[4]'")){
            return false;
        }

        $formated = $array[3]->format('Y-m-d');

        if ($array[2] == 1){
            $query = "UPDATE `donation` SET `amount` = NULL, `donation_type_id` = '$array[2]', `donation_date` = '$formated', `organ_id` = '$array[4]'  WHERE `id` ='$array[0]'";
        } 

        if ($array[2] == 2){
            $query = "UPDATE `donation` SET `amount` = '$array[1]', `donation_type_id` = '$array[2]', `donation_date` = '$formated', `organ_id` = '5'  WHERE `id` ='$array[0]'";
        } 

        return run_query($query, true);
        
    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {
        if (!column_exist('donation', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `donation` WHERE id = '$id'")){
            return false;
        }

        if ($column_name === 'donation_type_id')
        {
            if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        if ($column_name === 'organ_id')
        {
            if (!does_exist("SELECT * FROM `organ` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }


        $query = "UPDATE `donation` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";

        return run_query($query, true);

    }
    public static function VirtualDelete($id){
        // if (!does_exist("SELECT * FROM `donation` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }

    public static function Delete($id){
        if (!does_exist("SELECT * FROM `donation` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `donation` WHERE id = '$id'";
        return run_query($query, true);
    }




    // public static function update_donation($amount,$donation_id,$organ): bool
    // {
    //     if ($organ != NULL)
    //     {
    //         $query =  $query = "UPDATE `donation` SET organ = '$organ' WHERE id = '$donation_id' ";
    //     }
    //     else {
    //         $query =  $query = "UPDATE `donation` SET amount = '$amount' WHERE id = '$donation_id' ";
    //     }
    // return run_query($query, true);
    // }
    
        


}