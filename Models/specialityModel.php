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

class Speciality implements Create, Update, Delete, Read
{

    private ?int $id;
    private ?String $name;

    public function __construct(array $data)
    {

        $this->id = $data["id"];
        $this->name = $data["speciality_name"];
    }
    // setters
    public function getId(): ?int       { return $this->id; }
    public function getname():?String   { return $this->name; }

    // getters
    // public function setId($id)             { if(Speciality::ConditionedUpdate($this->id, 'id', $id)){$this->id = $id;}}
    public function setname($name)         { if(Speciality::ConditionedUpdate($this->id, 'speciality_name', $name)){$this->name = $name;};}


    public function __toString()
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Speciality Name: $this->name <br/>";
        return $str . '</pre>';
    }

    public static function Read_All()
    {   
        $Specialities = []; 
        $rows = run_select_query("SELECT * FROM `speciality`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Specialities[] = new Speciality($row); }
        } 
        else 
        {
            return false;
        }

        return $Specialities;
    }

    public static function Read($speciality_id)
    {

        $query = "SELECT * FROM `speciality` WHERE id = '$speciality_id'";

        if (!does_exist($query)){
            return false;
        }

        $rows = run_select_query("SELECT * FROM `speciality` WHERE id = '$speciality_id'");
        return new self($rows->fetch_assoc());

    }
    public static function Create($speciality_name): bool
    {
        $query = "INSERT INTO `speciality` (speciality_name) VALUES ('$speciality_name')";

        return run_query($query, true);
    }
    public static function Update($array)
    {
        if (!array_check($array, 2)){
            return false;
        }

        if (!does_exist("SELECT * FROM `speciality` WHERE id = '$array[0]'")){
            return false;
        }
        
        $query = "UPDATE `speciality` SET `speciality_name` = '$array[1]' WHERE `id` ='$array[0]'";

        return run_query($query, true);

    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {

        if (!column_exist('speciality', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `speciality` WHERE id = '$id'")){
            return false;
        }
        
        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `speciality` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        $query = "UPDATE `speciality` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }

    public static function VirtualDelete($id)
    {
        // if (!does_exist("SELECT * FROM `person` WHERE id = '$id'")){
        //     return false;
        // }

        return;
    }

    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `speciality` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `speciality` WHERE id = '$id'";
        return run_query($query, true);
    }
}

