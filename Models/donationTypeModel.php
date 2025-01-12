<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Utils\utils.php");

// CRUD
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Create.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Update.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Delete.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Read.php");

ob_end_clean();

class DonationType implements Create, Update, Delete, Read
{

    private ?int $id;
    private ?String $donation_type;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->donation_type = $data['donation_type'];
    }
    public function getId():int|null                {return $this->id;}
    public function get_donation_type():String|null {return $this->donation_type;}

    // public function setID($id)                        {if(DonationType::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;}}
    public function set_donation_type($donation_type) {if(DonationType::ConditionedUpdate($this->id,'donation_type',$donation_type)){$this->donation_type = $donation_type;}}


    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Donation's Type: $this->donation_type<br/>";

        return $str . '</pre>';
    }

    public static function Read_All()
    {
        $Donation_Types = []; 
        $rows = run_select_query("SELECT * FROM `donation_type`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Donation_Types[] = new DonationType($row); }
        } 
        else 
        {
            return false;
        }

        return $Donation_Types;
    }
    public static function Read($id)
    {
        $query = "SELECT * FROM `donation_type` WHERE id = '$id'";

        if (!does_exist($query)){
            return false;
        }
        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());
    }
    public static function Create($donation_type)
    {
        $query = "INSERT INTO `donation_type` (donation_type)
              VALUES ('$donation_type')";

        return run_query($query, true);

    }
    public static function Update($array)
    {
        if (!array_check($array, 2)){
            return false;
        }

        if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$array[0]'")){
            return false;
        }

        $query = "UPDATE `donation_type` SET `donation_type` = '$array[1]'  WHERE `id` ='$array[0]'";
        
        return run_query($query, true);

    }
    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {
        if (!column_exist('donation_type', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$id'")){
            return false;
        }

        $query = "UPDATE `donation_type` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);

    }
    public static function VirtualDelete($id)
    {
        // if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }
    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `donation_type` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `donation_type` WHERE id = '$id'";
        return run_query($query, true);

    }

    // public static function get_donation_type_by_id($donation_type_id): bool|DonationType
    // {
    //     $rows = run_select_query("SELECT * FROM `donation_type` WHERE id = '$donation_type_id'");
    //     if ($rows->num_rows > 0) {
    //         return new self($rows->fetch_assoc());
    //     } else {
    //         return false;
    //     }
    // }

    // public static function get_all_donation_types(): array
    // {
    //     $donationtypes = [];
    //     $rows = run_select_query("SELECT * FROM `donation_type`");

    //     if ($rows && $rows->num_rows > 0) {
    //         foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
    //             $donationtypes[] = new DonationType($row);
    //         }
    //     }
    //     return $donationtypes;
    // }
    // public static function add_donation_type($donation_type): bool
    // {
    //     $query = "INSERT INTO `donation_type` (donation_type)
    //           VALUES ('$donation_type')";

    //     return run_query($query, true);
    // }

    // public static function update_donation_type($donation_type_id, $donation_type): bool
    // {
    //     $query = "UPDATE `donation_type` SET donation_type = '$donation_type' WHERE id = '$donation_type_id' ";

    //     return run_query($query, true);
    // }
    // public static function delete_donation_type($donation_type_id): bool
    // {

    //     $query = "DELETE FROM `donation_type` WHERE id = '$donation_type_id'";
    //     return run_query($query, true);
    // }
}