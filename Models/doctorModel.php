<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once "personModel.php";
require_once "doctorrankModel.php";
require_once "specialityModel.php";
ob_end_clean();

class Doctor{

    private ?int $id;
    private int $person_id;
    private ?String $doctor_first_name;
    private ?String $doctor_last_name;
    private int $speciality_id;
    private ?String $doctor_speciality;
    private int $rank_id;
    private ?String $doctor_rank;
    private bool $isAvailable;
    
    public function __construct(array $data){

        $this->id = $data["doctor_id"];
        $this->doctor_first_name = $data["doctor_first_name"];
        $this->doctor_last_name = $data["doctor_last_name"];
        $this->doctor_rank = $data["doctor_rank"];
        $this->doctor_speciality = $data["doctor_speciality"];
        $this->isAvailable = $data["doctor_available"];
    }
    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->doctor_first_name <br/>";
        $str .= "Last Name: $this->doctor_last_name<br/>";
        $str .= "Doctor's Rank: $this->doctor_rank<br/>";
        $str .= "Doctor's Speciality: $this->doctor_speciality<br/>";
        $str .= "Doctor's Availability: $this->isAvailable<br/>";
        return $str . '</pre>';
    }

    public static function get_doctor_details(int $doctor_id): Doctor|bool {

        $query = "
            SELECT 
                doctor.id AS doctor_id,
                person.first_name AS doctor_first_name,
                person.last_name AS doctor_last_name,
                doctor_rank.rank AS doctor_rank,
                speciality.speciality_name AS doctor_speciality,
                doctor.isAvailable AS doctor_available
            FROM doctor
            JOIN person ON doctor.person_id = person.id
            JOIN doctor_rank ON doctor.rank_id = doctor_rank.id
            JOIN speciality ON doctor.speciality_id = speciality.id
            WHERE doctor.id = '$doctor_id'
        ";
    
        $rows = run_select_query($query);
        
        if ($rows->num_rows > 0) {
           
            return new self($rows->fetch_assoc());
        } else {
            return false; 
        }
    }

    public static function add_doctor(String $doctor_first_name,String $doctor_last_name,DateTime $doctor_birth_date, int $doctor_address_id,String $doctor_rank_name, String $doctor_speciality_name): Doctor|bool {
        
        global $conn;

        if (!Person::add_person($doctor_first_name, $doctor_last_name, $doctor_birth_date, $doctor_address_id)) {
            return false;
        }
        $person = Person::get_person_by_id($conn->insert_id);
        if (!$person) {
            return false;
        }
       


        if(!DoctorRank::add_doctor_rank($doctor_rank_name)){
            return false;
        };
        $doctor_rank = DoctorRank::get_doctor_rank($conn->insert_id);
        if (!$doctor_rank) {
            return false;
        }
       

        if(!Speciality::add_speciality($doctor_speciality_name)){
            return false;
        };
        $doctor_speciality  = Speciality::get_speciality_by_id($conn->insert_id);
        if (!$doctor_speciality) {
            return false;
        }



        $person_id = $person->getId();
        $doctor_rank_id = $doctor_rank->getId();
        $doctor_speciality_id = $doctor_speciality->getId();
        
        $query = 
        "INSERT INTO `doctor` (person_id, rank_id, speciality_id) 
         VALUES ('$person_id','$doctor_rank_id',' $doctor_speciality_id')";
    
        return run_query($query,true);
       
    }
}