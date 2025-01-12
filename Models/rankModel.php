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

class Rank implements Create, Update, Delete, Read
{

    private ?int $id;
    private ?String $rank;

    public function __construct(array $data)
    {

        // value(data) = array[key(column)]
        $this->id = $data['id'];
        $this->rank = $data['rank'];
    }

    // getters
    public function getId():int|null {return $this->id;}
    public function getRank():String|null{return $this->rank;}

    // Setters
    // public function setId($id)      { $this->id = $id; DoctorRank::ConditionedUpdate($this->id,'id', $id);}
    public function setRank($rank)   { $this->rank = $rank; Rank::ConditionedUpdate($this->id,'rank', $rank);}


    
    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Rank: $this->rank<br/>";

        return $str . '</pre>';
    }
    public static function Read_All()
    {   
        $Ranks = []; 
        $rows = run_select_query("SELECT * FROM `doctor_rank`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Ranks[] = new Rank($row); }
        } 
        else 
        {
            return false;
        }

        return $Ranks;
    }

    public static function Read($rankid): bool|Rank
    {
        $query = "SELECT * FROM `doctor_rank` WHERE id = '$rankid'";

        if (!does_exist($query)){
            return false;
        }

        $rows = run_select_query("SELECT * FROM `doctor_rank` WHERE id = '$rankid'");
        return new self($rows->fetch_assoc());

    }
    public static function Create($rank): bool
    {
        $query = "INSERT INTO `doctor_rank` (rank)
              VALUES ('$rank')";

        return run_query($query, true);
    }

    public static function Update($array): bool
    {
        if (!array_check($array, 2)){
            return false;
        }

        if (!does_exist("SELECT * FROM `doctor_rank` WHERE id = '$array[0]'")){
            return false;
        }

        $query = "UPDATE `doctor_rank` SET rank = '$array[1]' WHERE id = '$array[0]' ";

        return run_query($query, true);
    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {

        if (!column_exist('doctor_rank', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `doctor_rank` WHERE id = '$id'")){
            return false;
        }
        
        
        $query = "UPDATE `doctor_rank` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }
    
    public static function VirtualDelete($id)
    {
        // if (!does_exist("SELECT * FROM `doctor_rank` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }

    public static function Delete($rankid): bool
    {
        $query = "DELETE FROM `doctor_rank` WHERE id = '$rankid'";
        return run_query($query, true);
    }
}
