<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class DonorTier implements Create, Update, Delete, Read
{

    private ?int $id;
    private ?String $tier;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->tier = $data['tier']; 
    }
    // setters
    public function getId() {return $this->id;}
    public function getTier() {return $this->tier;}

    // getters
    // public function setId($id) {if(DonorTier::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;}}
    public function setTier($tier) {if(DonorTier::ConditionedUpdate($this->id,'tier',$tier)){$this->tier = $tier;}}

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Donor's Tier: $this->tier<br/>";
    
        return $str . '</pre>';
    }
    public static function Read_All()
    {        
        $Tiers = []; 
        $rows = run_select_query("SELECT * FROM `donor_tier`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Tiers[] = new DonorTier($row); }
        } 
        else 
        {
            return false;
        }

        return $Tiers;}
    public static function Read($id)
    {
        $query = "SELECT * FROM `donor_tier` WHERE id = '$id'";

        if (!does_exist($query)){
            return false;
        }
        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());
    }
    public static function Create($tier)
    {
        $query = "INSERT INTO `donor_tier` (tier)
              VALUES ('$tier')";

        return run_query($query, true);
    }
    public static function Update($array)
    {
        if (!array_check($array, 2)){
            return false;
        }

        if (!does_exist("SELECT * FROM `donor_tier` WHERE id = '$array[0]'")){
            return false;
        }
        

        $query = "UPDATE `donor_tier` SET `tier` = '$array[1]' WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }
    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {
        
        if (!column_exist('donor_tier', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `donor_tier` WHERE id = '$id'")){
            return false;
        }
        
        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `donor_tier` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }
        
        $query = "UPDATE `donor_tier` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }
    public static function VirtualDelete($id)
    {
        // if (!does_exist("SELECT * FROM `donor_tier` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }
    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `donor_tier` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `donor_tier` WHERE id = '$id'";
        return run_query($query, true);
    }


}