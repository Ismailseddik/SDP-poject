<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Observers\IObserver.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Utils\utils.php");

// CRUD
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Create.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Update.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Delete.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Read.php");




ob_end_clean();
class Person implements IObserver , Create, Update, Delete, Read
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

    public function getId(): int|null             { return $this->id; }
    public function getFirstName(): string|null   { return $this->first_name; }
    public function getLastName(): string|null    { return $this->last_name; }
    public function getBirthDate(): DateTime|null { return $this->birth_date; }
    public function getisDeleted()                { return $this->birth_date; }
    // public function getAddress():array
    // {
    //     $address_tree = [];
    //     Address::get_address_by_id($this->address_id, $address_tree);
    //     return $address_tree;
    // } 

    // public function setID($id)                { if(Person::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;}}
    public function setFirstName($first_name) { if(Person::ConditionedUpdate($this->id,'first_name',$first_name)){$this->first_name = $first_name;}}
    public function setLastName($last_name)   { if(Person::ConditionedUpdate($this->id,'last_name',$last_name)){$this->last_name = $last_name;}}
    public function setBirthDate($birth_date) { if(Person::ConditionedUpdate($this->id,'birth_date',$birth_date)){ $this->birth_date = $birth_date;}}
    public function setisDeleted($isDeleted)  { if(Person::ConditionedUpdate($this->id,'isDeleted',$isDeleted)){$this->birth_date = $isDeleted;}}
    // public function setAddress():array{}



    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->first_name <br/>";
        $str .= "Last Name: $this->last_name<br/>";
        $str .= "Date of Birth: " . ($this->birth_date ? $this->birth_date->format('Y-m-d') : 'N/A') . "<br/>";
        $str .= "Address_ID: $this->address_id<br/>";

        return $str . '</pre>';
    }

    public static function Read_All()
    {   
        $People = []; 
        $rows = run_select_query("SELECT * FROM `person`");
        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $People[] = new Person($row); }
        } 
        else 
        {
            return false;
        }

        return $People;
    }

    public static function Read($id)
    {
        $query = "SELECT * FROM `person` WHERE id = '$id'";

        if (!does_exist($query)){
            return false;
        }
        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());

    }

    public static function Create($array)
    {
        // this function takes only as the ID is auto increment and deleted is auto filled by zero 
        if (!array_check($array, 4)){
            return false;
        }

        $birth_date_formatted = $array[2]->format('Y-m-d');
        $query = "INSERT INTO `person` (first_name, last_name,  birth_date , address_id)
              VALUES ('$array[0]', '$array[1]',  '$birth_date_formatted' ,'$array[3]')";

        return run_query($query, true);
    }

    public static function Update($array): bool
    {
        if (!array_check($array, 5)){
            return false;
        }

        if (!does_exist("SELECT * FROM `person` WHERE id = '$array[0]'")){
            return false;
        }
        
        $formated = $array[3]->format('Y-m-d');

        $query = "UPDATE `person` SET `first_name` = '$array[1]', `last_name` = '$array[2]', `birth_date` = '$formated', `address_id` = '$array[4]'  WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {

        if (!column_exist('person', $column_name)){ return false; }

        if (!does_exist("SELECT * FROM `person` WHERE id = '$id'")){
            return false;
        }
        
        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `person` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }
        
        $query = "UPDATE `person` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }


    public static function VirtualDelete($id)
    {
        if (!does_exist("SELECT * FROM `person` WHERE id = '$id'")){
            return false;
        }

        $query = "UPDATE `person` SET isDeleted = 1 WHERE id ='$id'";
        return run_query($query, true);
    }

    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `person` WHERE id = '$id'")){
            return false;
        }

        $query = "DELETE FROM `person` WHERE id = '$id'";
        return run_query($query, true);
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

    public function update_obeserver(int $id):void
    {
        return;
    }

    
}
