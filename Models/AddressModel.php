<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

// CRUD
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Create.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Update.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Delete.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Read.php");

class Address implements Create, Update, Delete, Read{
    
    private ?int $id;
    private ?String $name; 
    private ?int $parent_id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name']; 
        $this->parent_id = $data['parent_id'];
    }

    // Getters 
    public function getID()      {return $this->id;}
    public function getName()    {return $this->name;}
    public function getParentID(){return $this->parent_id;}

    // Setters
    public function setID($id)              { $this->id = $id;}
    public function setName($name)          { $this->name = $name;}
    public function setParentID($parent_id) { $this->parent_id = $parent_id;}


    public static function Read_All()
    {

    } 
    public static function Read($id)
    {

    }
    
    public static function Create($array):bool
    { 
        // only two because the key is auto increment so it will not be in the array elements
        if (!array_check($array, 2)){
            return false;
        }

        // check if the parent_id exists as a key in the 'address' table 
        if (!does_exist("SELECT * FROM `address` WHERE id = '$array[1]'")){
            return false;
        }

        $query = "INSERT INTO `address` (`name`, `parent_id`) VALUES ('$array[0]', '$array[1])";
        return run_query($query,true);
    }
    public static function Update($array)
    {
        if (!array_check($array, 3)){
            return false;
        }

        // check if the they key passed already exists
        if (!does_exist("SELECT * FROM `address` WHERE id = '$array[0]'")){
            return false;
        }

        // check if the parent_id exists as a key in the 'address' table 
        if (!does_exist("SELECT * FROM `address` WHERE id = '$array[2]'")){
            return false;
        }

        $query = "UPDATE `address` SET `name` = '$array[1]', `parent_id` = '$array[2]'  WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }
    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {}
    public static function VirtualDelete($id)
    {}
    public static function Delete($id)
    {}
    public static function get_address_by_id(int $id, array &$address_list):void
    {
        if($id === 0){return;}

        $query = "
        SELECT
            address.name,
            address.parent_id
        From address
        where address.id = '$id'

        ";
        $rows = run_select_query($query);
        if (!$rows) {
            echo "Error: Query execution failed in getting_address_by_id.";
            return ;
        } elseif ($rows->num_rows === 0) {
            echo "Debug: Query executed but returned no results in getting_address_by_id.";
            return ;
        } else {
            echo "Debug: Query successful, fetching addresses\n";
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) 
            {
                array_push($address_list,$row['name']);
                Address::get_address_by_id((int)$row['parent_id'],$address_list);
                
            }

        }
        

    }


    public static function get_address_by_name(int $id , string $name):bool
    {
        if($id === 0){return false;}

        $query = "
        SELECT
            address.name,
            address.parent_id
        From address
        where address.id = '$id'

        ";
        $rows = run_select_query($query);
        if (!$rows) {
            echo "Error: Query execution failed in getting_address_by_id.";
            return false;
        } elseif ($rows->num_rows === 0) {
            echo "Debug: Query executed but returned no results in getting_address_by_id.";
            return false;
        } else {
            echo "Debug: Query successful, fetching addresses\n";
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) 
            {
                if ((string)$row["name"] === (string)$name)
                {
                    return true;
                }
                else 
                {
                    if(Address::get_address_by_name((int)$row['parent_id'], $name))
                    {
                        return true;
                    }
                }
                
            }

        }
        
        return false;
    }
}
