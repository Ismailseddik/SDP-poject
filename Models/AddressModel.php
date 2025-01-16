<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\interfaces\ISelfRefrence.php");


class Address extends Iterators implements ISelfRefrence{

    private int $id;
    private string $name;   
    private int $parent_id;   

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name =  $data['name'];
        $this->parent_id =  $data['parent_id'];
    }

    public function getID() {return $this->id;}
    public function getName() {return $this->name;}
    public function getParentID() {return $this->parent_id;}
    

    public static function Read($id)
    {
        $row = run_select_query("SELECT * FROM `address` WHERE id = '$id'");

        if ($row->num_rows > 0) {
            return new self($row->fetch_assoc());
        } else {
            return false;
        }

    }
    public static function ReadAll($id)
    {
        $Addresses = [];
        $rows = run_select_query("SELECT * FROM `address`");
        if ($rows && $rows->num_rows > 0) 
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $Addresses[] = new Address($itr->Next());
            }
        }

        return $Addresses;
    }

    public static function Create($name , $parent_id):bool
    { 
        $query = "INSERT INTO `address` (`name`, `parent_id`) VALUES ('$name', '$parent_id)";
        return run_query($query,true);
    }

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
