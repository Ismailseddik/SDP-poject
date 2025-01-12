<?php
// Patient.php
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once "personModel.php";
include_once($_SERVER["DOCUMENT_ROOT"] . "\Utils\utils.php");

// CRUD
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Create.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Update.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Delete.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\CRUD\Read.php");

class Patient extends Person implements Create, Update, Delete, Read
{
    protected ?int $id;
    protected ?int $person_id;


    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->person_id = $data['person_id'] ?? null;
    }

    // Getters
    public function getId(): int|null       { return $this->id; }
    public function getPersonId(): int|null { return $this->person_id;}
    // overridden Getters
    public function getFirstName(): string|null    { return Person::Read($this->person_id)->getFirstName(); }
    public function getLastName(): string|null     { return Person::Read($this->person_id)->getLastName(); }
    public function getBirthDate(): DateTime|null  { return Person::Read($this->person_id)->getBirthDate(); }
    public function getisDeleted()                 { return Person::Read($this->person_id)->getisDeleted();  }
    // public function getAddress()

    // Setters

    public function setID($id)                      {  if(Patient::ConditionedUpdate($this->id,'id',$id)){$this->id = $id;}}
    public function setPersonID($person_id)         {  if(Patient::ConditionedUpdate($this->id, "person_id", $person_id)){$this->person_id = $person_id; }}
    // overridden Setters
    public function setFirstName($first_name) { if(Person::ConditionedUpdate($this->id,'first_name',$first_name)){$this->first_name = $first_name;}}
    public function setLastName($last_name)   { if(Person::ConditionedUpdate($this->id,'last_name',$last_name)){$this->last_name = $last_name;}}
    public function setBirthDate($birth_date) { if(Person::ConditionedUpdate($this->id,'birth_date',$birth_date)){ $this->birth_date = $birth_date;}}
    public function setisDeleted($isDeleted)  { if(Person::ConditionedUpdate($this->id,'isDeleted',$isDeleted)){$this->birth_date = $isDeleted;}}
    // Fetch all patients with associated personal details
    public static function Read_All(): array
    {        
        $Patients = [];
        $rows = run_select_query("SELECT * FROM `patient`");

        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Patients[] = new Patient($row); }
        } 
        else 
        {
            return false;
        }

        return $Patients;
    }

    public static function Read($patient_id): bool|Patient
    {
        
        $query = "SELECT * FROM `patient` WHERE id = '$patient_id'";

        // check if this patient_id already exists in DB or not 
        if (!does_exist($query)){
            return false;
        }

        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());
    }

    // Add a new patient with personal details
    public static function Create($person_id): bool
    {

        // checking if person_id alrealy exists in pesrson Table
        if (!does_exist("SELECT * FROM `person` WHERE id = '$person_id'")){
            return false;
        }

        $query = "
            INSERT INTO `patient` (person_id) 
            VALUES ('$person_id')
        ";

        return run_query($query, true);
    }

    public static function Update($array): bool
    {
        if (!array_check($array, 2)){
            return false;
        }
        if (!does_exist("SELECT * FROM `patient` WHERE id = '$array[0]'")){
            return false;
        }
        // Foreign keys check
        if (!does_exist("SELECT * FROM `person` WHERE id = '$array[1]'")){
            return false;
        }
        
        $query = "UPDATE `patient` SET `person_id` = '$array[1]' WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {

        if (!column_exist('patient', $column_name)){ return false; }


        if (!does_exist("SELECT * FROM `patient` WHERE id = '$id'")){
            return false;
        }

        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `patient` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        if ($column_name === 'person_id')
        {
            if (!does_exist("SELECT * FROM `person` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }
        
        $query = "UPDATE `patient` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }

    public static function VirtualDelete($id)
    {
        if (!does_exist("SELECT * FROM `patient` WHERE id = '$id'")){
            return false;
        }

        Person::VirtualDelete(Patient::Read($id)->getPersonID());
    }
    // Decided cascade delete
    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `patient` WHERE id = '$id'")){
            return false;
        }

        // we wrote this here because we cannot retireve that ID again from doctor table after deleting its record
        $person_id = Patient::Read($id)->getPersonID();

        $query = "DELETE FROM `patient` WHERE id = '$id'";
        run_query($query, true);

        Person::Delete($person_id);

        
    }
    


}
