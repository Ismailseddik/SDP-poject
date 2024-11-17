<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

class Address{

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
