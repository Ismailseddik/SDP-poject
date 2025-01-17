<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Observers\IObserver.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");

ob_end_clean();
class Person extends Iterators implements IObserver
{

    protected ?int $id = null;
    protected ?string $first_name = null;
    protected ?string $last_name = null;
    protected ?DateTime $birth_date = null;
    protected ?int $address_id = null;
    protected ?bool $isDeleted = false;
    
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->birth_date = isset($data['birth_date']) ? new DateTime($data['birth_date']) : null;
        $this->address_id = $data['address_id'] ?? null;
        $this->isDeleted = $data['isDeleted'] ?? null;
    }

    public function getId(): int|null           { return $this->id; }
    public function getFirstName(): string|null { return $this->first_name; }
    public function getPersonId(): int|null     { return $this->id;}
    public function getLastName(): string|null  { return $this->last_name; }
    public function getAddressId()              { return $this-> address_id;}
    public function getAddress()                { return Address::getFullAdressByID($this->address_id); } 

    public static function getby_id($Id)
    {
        $rows = run_select_query("SELECT * FROM `person` WHERE id = '$Id'");
        if ($rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            return false;
        }
    }
    public static function ReadAll()
    {
        $People = [];
        $rows = run_select_query("SELECT * FROM `person`");
        if ($rows && $rows->num_rows > 0)
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $People[] = new Person($itr->Next());
            }  
        }

        return $People;
    }
    public static function add_person($first_name, $last_name, $birth_date, $address_id): bool
    {
        $birth_date_formatted = $birth_date->format('Y-m-d');
        $query = "INSERT INTO `person` (first_name, last_name,  birth_date , address_id)
              VALUES ('$first_name', '$last_name',  '$birth_date_formatted' ,'$address_id')";

        return run_query($query, true);
    }

    public static function getUserByEmail($email){
        $rows = run_select_query("SELECT * FROM `user_login_information` WHERE email = '$email'");
        if ($rows->num_rows > 0) {
            $row = $rows->fetch_assoc();
            return $row; 
        } else {
            return false;
        }
        
    }

    // public static function get_all_by_address_name($name){
    //     $query = "
    //     SELECT
    //         person.id,  
    //         address.id
    //     From person 
    //     ";

    //     $rows = run_select_query($query);


        
    // }


    public static function update(array $array): bool
    {
        if (!isset($array['person_id'])) {
            return false; // Ensure 'id' is provided
        }
        $id = $array['person_id'];
        $set_parts = [];

    if ($array['first_name'] !== null) {
    
        $set_parts[] = "`first_name` = '" . $array['first_name'] . "'";
    }
    if ($array['last_name'] !== null) {
   
        $set_parts[] = "`last_name` = '" . $array['last_name'] . "'";
    }
    if ($$array['birth_date'] !== null) {
        
        $set_parts[] = "`birth_date` = '" . $array['birth_date']->format('Y-m-d') . "'";
    }
    if ($array['address_id'] !== null) {
       
        $set_parts[] = "`address_id` = " . $array['address_id'];
        
    }
    
    if (empty($set_parts)) {
        return false; 
    }
    
    $set_clause = implode(', ', $set_parts);
    $query = "UPDATE `person` SET $set_clause WHERE `id` = $id";
    
    return run_query($query, true);
    }

    public static function delete($id)
    {

        $query = "UPDATE `person` SET isDeleted = 1 WHERE id ='$id'";//person_id for person
        return run_query($query, true);
    }

    public function update_obeserver():void
    {
        return;
    }

    
}
