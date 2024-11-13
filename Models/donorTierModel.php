<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class DonorTierModel{

    private ?int $id;
    private ?String $tier;

    public function __construct(array $data){

    // value(data) = array[key(column)]
    $this->id = $data['id'];
    $this->tier = $data['tier']; 
    }
    public function getId(): ?int{
        return $this->id;
    }
    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Donor's Tier: $this->tier<br/>";
    
        return $str . '</pre>';
    }

    public static function get_donor_tier($tier_id): bool|DonorTierModel{
        $rows= run_select_query("SELECT * FROM `donor_tier` WHERE id = '$tier_id'");
        if($rows->num_rows > 0){
            return new self($rows->fetch_assoc());
        }else{
            return false ;
        }

    }  
    public static function add_donor_tier($tier): bool
    {
    $query = "INSERT INTO `donor_tier` (tier)
              VALUES ('$tier')";
    
    return run_query($query, true);
    }

    public static function update_donor_tier($tier_id,$tier): bool
    {
    $query = "UPDATE `donor_tier` SET tier = '$tier' WHERE id = '$tier_id' ";
           
    return run_query($query, true);
    }
    public static function delete_donor_tier($tier_id): bool{
        
    $query = "DELETE FROM `donor_tier` WHERE id = '$tier_id'";
        return run_query($query, true);

        
    }
}