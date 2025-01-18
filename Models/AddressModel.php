<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\interfaces\IComposite.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\interfaces\ISelfRefrence.php");


class Address extends Iterators implements ISelfRefrence, IComposite{

    private int $id;
    private string $name;   
    private int $parent_id;
    private array $Children;   

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name =  $data['name'];
        $this->parent_id =  $data['parent_id'];
        $this->setChildren();
    }

    public function getID()       {return $this->id;}
    public function getName()     {return $this->name;}
    public function getParentID() {return $this->parent_id;}
    public function getChildren() {return $this->Children;}
    

    public static function Read($id)
    {
        $row = run_select_query("SELECT * FROM `address` WHERE id = '$id'");

        if ($row->num_rows > 0) 
        {return new self($row->fetch_assoc());}
         
        else 
        {return false;}

    }
    public static function ReadAll()
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

    public static function Update($array)
    {
        // private int $id;
        // private string $name;   
        // private int $parent_id;
        $query =  $query = "UPDATE `address` SET  `name` = $array[1], `parent_id`=$array[2]  WHERE id = '$array[0]' ";
    
        return run_query($query, true);
    }

    public static function Delete($id)
    {
        $query = "DELETE FROM `address` WHERE id = '$id'";
        return run_query($query, true);
    }

    public static function getFullAdressByID(int $id)
    {
        $FullAddress = [];
        $PartialAddress = Address::Read($id);

        $itr = self::getSelfRefrenceIterator();
        $itr->SetIterable($PartialAddress);
        while($itr->HasNext())
        {
            $FullAddress [] = $PartialAddress->getName();
            $PartialAddress = Address::Read($itr->Next());
            $itr->SetIterable($PartialAddress);
        }
        // Append the Root Node Name
        $FullAddress [] = $PartialAddress->getName();

        return $FullAddress;

    }

    public static function getWhoLiveIn(String $name)
    {   
        // Map so we could not iterate over visited IDs Twice
        $Excluded_IDs = [];
        $Included_IDs = [];
        $All_People_Who_lives = [];

        $People = Person::ReadAll();
        $ArrayItr = self::getArrayIterator();
        $ArrayItr->SetIterable($People);
        while($ArrayItr->HasNext())
        {
            $Curr_Person = $ArrayItr->Next();
            $Curr_AddressID = $Curr_Person->getAddressId();
            if(array_key_exists($Curr_AddressID,$Included_IDs))
            {
                $All_People_Who_lives [] = $Curr_Person;
            }
            elseif(array_key_exists($Curr_AddressID,$Excluded_IDs))
            {
                continue;
            }
            else
            {  
                $Found = false;
                $AdrressOfId = Address::getFullAdressByID($Curr_AddressID);

                $AddressItr = new CustomArrayIterator();
                $AddressItr->SetIterable($AdrressOfId);
                while($AddressItr->HasNext())
                {
                    if($AddressItr->Next() == $name)
                    {
                        $All_People_Who_lives [] = $Curr_Person;
                        $Included_IDs[$Curr_AddressID] = $Curr_AddressID;
                        $Found = true;
                        break;
                    }

                }
                if (!$Found)
                {
                    $Excluded_IDs[$Curr_AddressID] = $Curr_AddressID;
                }
            }

        }

        return $All_People_Who_lives;

        

    }

    private function setChildren()
    {
        $my_id = $this->getID();
        $rows = run_select_query("SELECT * FROM `address` WHERE parent_id = '$my_id'");
        if ($rows && $rows->num_rows > 0) 
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $this->Children [] = new Address($itr->Next());
            }
        }
        else {$this->Children = [];}


    }

    public function AddChild(object $Child)
    {
        $this->Children [] = $Child;
    }

    public function IterateChildren()
    {
        $Tree = [];
        $ArrayItr = self::getArrayIterator();
        $ArrayItr->SetIterable($this->getChildren());

        $CompositeItr = self::getCompositeIterator();
        $CompositeItr->SetIterable($ArrayItr);

        while($CompositeItr->HasNext())
        {
            $Tree [] = $CompositeItr->Next()->getName();
        }

        return $Tree;
    }

    // public static function get_address_by_id(int $id, array &$address_list):void
    // {
    //     if($id === 0){return;}

    //     $query = "
    //     SELECT
    //         address.name,
    //         address.parent_id
    //     From address
    //     where address.id = '$id'

    //     ";
    //     $rows = run_select_query($query);
    //     if (!$rows) {
    //         echo "Error: Query execution failed in getting_address_by_id.";
    //         return ;
    //     } elseif ($rows->num_rows === 0) {
    //         echo "Debug: Query executed but returned no results in getting_address_by_id.";
    //         return ;
    //     } else {
    //         echo "Debug: Query successful, fetching addresses\n";
    //         foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) 
    //         {
    //             array_push($address_list,$row['name']);
    //             Address::get_address_by_id((int)$row['parent_id'],$address_list);
                
    //         }

    //     }
        

    // }
    // public static function get_address_by_name(int $id , string $name):bool
    // {
    //     if($id === 0){return false;}

    //     $query = "
    //     SELECT
    //         address.name,
    //         address.parent_id
    //     From address
    //     where address.id = '$id'

    //     ";
    //     $rows = run_select_query($query);
    //     if (!$rows) {
    //         echo "Error: Query execution failed in getting_address_by_id.";
    //         return false;
    //     } elseif ($rows->num_rows === 0) {
    //         echo "Debug: Query executed but returned no results in getting_address_by_id.";
    //         return false;
    //     } else {
    //         echo "Debug: Query successful, fetching addresses\n";
    //         foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) 
    //         {
    //             if ((string)$row["name"] === (string)$name)
    //             {
    //                 return true;
    //             }
    //             else 
    //             {
    //                 if(Address::get_address_by_name((int)$row['parent_id'], $name))
    //                 {
    //                     return true;
    //                 }
    //             }
                
    //         }

    //     }
        
    //     return false;
    // }
}
