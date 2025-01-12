<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once "personModel.php";
require_once "rankModel.php";
require_once "specialityModel.php";
ob_end_clean();

class Doctor extends Person implements Create, Update, Delete, Read
{
    protected ?int $id;
    protected ?int $person_id;
    protected ?int $speciality_id;
    protected ?int $rank_id;
    protected bool $isAvailable;
    // protected array $applications = []; // Add the applications property

    // Other methods...

    // public function setApplications(array $applications): void {
    //     $this->applications = $applications;
    // }

    // public function getApplications(): array {
    //     return $this->applications;
    // }

    //!! Remember that a constructor is making an object of an entry already in the database
    public function __construct(array $data)
    {   
        $this->id = $data["id"] ?? null;
        $this->person_id = $data["person_id"] ?? null;  // Initialize person_id
        $this->speciality_id = $data["speciality_id"] ?? null;  // Initialize speciality_id
        $this->rank_id = $data["rank_id"] ?? null;  // Initialize rank_id
        $this->isAvailable = $data["isAvailble"] ?? false;
    }

    // Getters

    public function getId(): int|null              { return $this->id;}
    public function getPersonID(): int|null        { return $this->person_id;}
    public function getSpecialityID(): string|null { return $this->speciality_id; }
    public function getRankID(): string|null       { return $this->rank_id; }
    public function getAvailablity(): string       { return $this->isAvailable ? "Yes" : "No"; }

    public function getRank()                      { return Rank::Read($this->getRankID())->getRank();}
    public function getSpeciality()                { return Speciality::Read($this->getSpecialityID())->getname();}


    // overriden Getters
    public function getFirstName(): string|null    { return Person::Read($this->person_id)->getFirstName(); }
    public function getLastName(): string|null     { return Person::Read($this->person_id)->getLastName(); }
    public function getBirthDate(): DateTime|null  { return Person::Read($this->person_id)->getBirthDate(); }
    public function getisDeleted()                 { return Person::Read($this->person_id)->getisDeleted();  }
    // public function getAddress()

    // Setters

    // public function setID($id)                      {  $this->id = $id; Doctor::ConditionedUpdate($this->id,'id',$id);}
    public function setPersonID($person_id)         {  if(Doctor::ConditionedUpdate($this->id, "person_id", $person_id)){$this->person_id = $person_id;}}
    public function setSpecialityID($speciality_id) {  if(Doctor::ConditionedUpdate($this->id, "speciality_id", $speciality_id)){$this->speciality_id = $speciality_id;}}
    public function setRankID($rank_id)             {  if(Doctor::ConditionedUpdate($this->id, "rank_id", $rank_id)){$this->rank_id = $rank_id;}}
    public function setAvailablity($isAvailable)    {  if(Doctor::ConditionedUpdate($this->id, "isAvailable", $isAvailable)){ $this->isAvailable = $isAvailable;}}

    // overridden Setters
    public function setFirstName($first_name) { if(Person::ConditionedUpdate($this->id,'first_name',$first_name)){$this->first_name = $first_name;}}
    public function setLastName($last_name)   { if(Person::ConditionedUpdate($this->id,'last_name',$last_name)){$this->last_name = $last_name;}}
    public function setBirthDate($birth_date) { if(Person::ConditionedUpdate($this->id,'birth_date',$birth_date)){ $this->birth_date = $birth_date;}}
    public function setisDeleted($isDeleted)  { if(Person::ConditionedUpdate($this->id,'isDeleted',$isDeleted)){$this->isDeleted = $isDeleted;}}


    public static function Read_All(): array
    {
        $Doctors = [];

        $rows = run_select_query("SELECT * FROM `doctor`");

        if ($rows->num_rows > 0) 
        {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) { $Doctors[] = new Doctor($row); }
        } 
        else 
        {
            return false;
        }

        return $Doctors;
    }

    public static function Read($doctor_id): Doctor|bool
    {

        $query = "SELECT * FROM `doctor` WHERE id = '$doctor_id'";

        if (!does_exist($query)){
            return false;
        }

        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());
    }
    public static function Create($array){

        if (!array_check($array, 4)){
            return false;
        }

        // checking if person_id alrealy exists in 
        if (!does_exist("SELECT * FROM `person` WHERE id = '$array[0]'")){
            return false;
        }

        $query = "
            INSERT INTO `doctor` (person_id, rank_id, speciality_id, isAvailable) 
            VALUES ('$array[0]', '$array[1]', '$array[2]', '$array[3]')
        ";

        return run_query($query, true);
    }

    public static function Update($array): bool
    {
        if (!array_check($array, 5)){
            return false;
        }
        if (!does_exist("SELECT * FROM `doctor` WHERE id = '$array[0]'")){
            return false;
        }

        // Foreign keys check
        if (!does_exist("SELECT * FROM `person` WHERE id = '$array[1]'")){
            return false;
        }

        if (!does_exist("SELECT * FROM `speciality` WHERE id = '$array[2]'")){
            return false;
        }

        if (!does_exist("SELECT * FROM `doctor_rank` WHERE id = '$array[3]'")){
            return false;
        }
        
        $query = "UPDATE `doctor` SET `person_id` = '$array[1]', `speciality_id` = '$array[2]', `rank_id` = '$array[3]', `isAvailable` = '$array[4]'  WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }

    public static function ConditionedUpdate($id, $column_name, $new_attribute_value)
    {

        if (!column_exist('doctor', $column_name)){ return false; }


        if (!does_exist("SELECT * FROM `doctor` WHERE id = '$id'")){
            return false;
        }

        // checking if the id we want change does not already exist in the table
        if (($column_name === 'id') and ($id != $new_attribute_value))
        {
            if (!does_exist("SELECT * FROM `doctor` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        if ($column_name === 'person_id')
        {
            if (!does_exist("SELECT * FROM `person` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        if ($column_name === 'speciality_id')
        {
            if (!does_exist("SELECT * FROM `speciality` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }
        
        if ($column_name === 'rank_id')
        {
            if (!does_exist("SELECT * FROM `doctor_rank` WHERE id = '$new_attribute_value'")){
                return false;
            }
        }

        
        $query = "UPDATE `doctor` SET `$column_name` = '$new_attribute_value'  WHERE `id` ='$id'";
        
        return run_query($query, true);
    }

    public static function VirtualDelete($id)
    {
        if (!does_exist("SELECT * FROM `doctor` WHERE id = '$id'")){
            return false;
        }

        Person::VirtualDelete(Doctor::Read($id)->getPersonID());
    }

    // Decided cascade delete
    public static function Delete($id)
    {
        if (!does_exist("SELECT * FROM `doctor` WHERE id = '$id'")){
            return false;
        }

        // we wrote this here because we cannot retireve that ID again from doctor table after deleting its record
        $person_id = Doctor::Read($id)->getPersonID();

        $query = "DELETE FROM `doctor` WHERE id = '$id'";
        run_query($query, true);

        Person::Delete($person_id);

        
    }



    public function update_obeserver(int $patient_id): void {
        // Fetch the application data for the given patient
        $application = PatientMedicalApplicationModel::get_applications_by_patient($patient_id);
    
        if ($application) {
            // Generate a notification message
            $message = "You have a new medical aid application for Patient ID: $patient_id (Application ID: " . $application->getApplicationId() . ").";
    
            // Store the notification for this doctor (e.g., log or save in persistent storage)
            error_log("Notification for Doctor ID {$this->getId()}: $message");
    
            // Optional: Perform further actions, such as sending an email or updating a dashboard
        } else {
            error_log("No application found for Patient ID: $patient_id.");
        }
    }

    public static function getApplicationsForDoctor(int $doctor_id): array {
        $query = "
            SELECT 
                patient_medical_aid_application.id AS application_id,
                person.first_name AS patient_first_name,
                person.last_name AS patient_last_name,
                patient_medical_aid_application.status_id
            FROM patient_medical_aid_application
            JOIN medical_aid_application ON patient_medical_aid_application.application_id = medical_aid_application.id
            JOIN patient ON patient_medical_aid_application.patient_id = patient.id
            JOIN person ON patient.person_id = person.id
            WHERE medical_aid_application.doctor_id = '$doctor_id'
        ";

        $applications = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            while ($row = $rows->fetch_assoc()) {
                $applications[] = $row;
            }
        }

        return $applications;
    }
}
