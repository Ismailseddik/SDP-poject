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

class Organ implements Create, Update, Delete, Read
{

    private int $id;
    private ?string $organ_name;

    public function getId()             {return $this->id;}
    public function get_organ_name()    {return $this->organ_name;}

    // public function setId($id){if(Organ::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;} }
    public function set_organ_name($organ_name){if(Organ::ConditionedUpdate($this->id,'organ_name',$organ_name)){$this->organ_name = $organ_name;}}

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->organ_name = $data['organ_name'] ?? null;
    }
    public static function Read_All()
    {
        $Organs = []; 
        $rows = run_select_query("SELECT * FROM `organ`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Organs[] = new Organ($row); }
        } 
        else 
        {
            return false;
        }

        return $Organs;
    }

    public static function Read($id)
    {
        $query = "SELECT * FROM `organ` WHERE id = '$id'";

        if (!does_exist($query)){
            return false;
        }
        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());
    }

    public static function Create($organ_name)
    {
        $query = "INSERT INTO `organ` (organ_name)
        VALUES ('$organ_name')";

        return run_query($query, true);
    }
    public static function Update($array) 
    {
        if (!array_check($array, 2)){
            return false;
        }
        
        if (!does_exist("SELECT * FROM `organ` WHERE id = '$array[0]'")){
            return false;
        }

        $query = "UPDATE `organ` SET `organ_name` = '$array[1]'  WHERE `id` ='$array[0]'";
        
        return run_query($query, true);



    }
    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {
        if (!column_exist('organ', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `organ` WHERE id = '$id'")){
            return false;
        }
        
        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `organ` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }
        
        $query = "UPDATE `organ` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }
    public static function VirtualDelete($id)
    {
        // if (!does_exist("SELECT * FROM `organ` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }
    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `organ` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `organ` WHERE id = '$id'";
        return run_query($query, true);
    }
}
