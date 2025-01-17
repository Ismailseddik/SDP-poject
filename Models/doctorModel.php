<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once "personModel.php";
require_once "doctorrankModel.php";
require_once "specialityModel.php";
require_once "../Models/patientMedicalApplicationModel.php";
ob_end_clean();

class Doctor extends Person 
{
    private ?int $person_id;
    private ?PatientMedicalApplicationModel $current;
    private ?int $speciality_id;
    private ?string $doctor_speciality;
    private ?int $rank_id;
    private ?string $doctor_rank;
    private bool $isAvailable;
    protected array $applications = []; // Add the applications property

    // Other methods...

    public function setApplications(array $applications): void {
        $this->applications = $applications;
    }

    public function getApplications(): array {
        return $this->applications;
    }

    public function __construct(array $data)
    {
        $this->id = $data["doctor_id"] ?? null;
        $this->person_id = $data["person_id"] ?? null;  // Initialize person_id
        $this->first_name = $data["doctor_first_name"] ?? null;
        $this->last_name = $data["doctor_last_name"] ?? null;
        $this->speciality_id = $data["speciality_id"] ?? null;  // Initialize speciality_id
        $this->doctor_speciality = $data["doctor_speciality"] ?? null;
        $this->rank_id = $data["rank_id"] ?? null;  // Initialize rank_id
        $this->doctor_rank = $data["doctor_rank"] ?? null;
        $this->isAvailable = $data["doctor_available"] ?? false;
    }

    public function getFirstName(): string|null { return $this->first_name; }
    public function getPersonId(): int|null{ return $this->person_id;}
    public function getId(): int|null {return $this->id;}
    public function getLastName(): string|null { return $this->last_name; }
    public function getSpeciality(): string|null { return $this->doctor_speciality; }
    public function getRank(): string|null { return $this->doctor_rank; }
    public function isAvailable(): string { return $this->isAvailable ? "Yes" : "No"; }

    public static function get_all_doctors_details(): array
    {
        $query = "
            SELECT 
                doctor.id AS doctor_id,
                doctor.person_id,
                person.first_name AS doctor_first_name,
                person.last_name AS doctor_last_name,
                doctor_rank.rank AS doctor_rank,
                speciality.speciality_name AS doctor_speciality,
                doctor.isAvailable AS doctor_available
            FROM doctor
            JOIN person ON doctor.person_id = person.id
            JOIN doctor_rank ON doctor.rank_id = doctor_rank.id
            JOIN speciality ON doctor.speciality_id = speciality.id
        ";

        $doctors = [];
        $rows = run_select_query($query);

        if (!$rows) {
            echo "Error: Query execution failed in get_all_doctors_details.";
            return [];
        } elseif ($rows->num_rows === 0) {
            echo "Debug: Query executed but returned no results in get_all_doctors_details.";
        } else {
            echo "Debug: Query successful, fetching doctors in get_all_doctors_details.";
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $doctors[] = new Doctor($row);
            }
        }

        return $doctors;
    }

    public static function getby_id($doctor_id): Doctor|bool
    {
        $query = "
            SELECT 
                doctor.id AS doctor_id,
                doctor.person_id,
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

        if ($rows && $rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            echo "Error: Doctor with ID $doctor_id not found.";
            return false;
        }
    }

    public static function add_doctor(
        string $doctor_first_name,
        string $doctor_last_name,
        DateTime $doctor_birth_date,
        int $doctor_address_id,
        int $doctor_rank_id,
        int $doctor_speciality_id
    ): bool {
        $conn=DataBase::getInstance()->getConn();

        if (!Person::add_person($doctor_first_name, $doctor_last_name, $doctor_birth_date, $doctor_address_id)) {
            echo "Error: Unable to add person record.";
            return false;
        }
        $person = Person::getby_id($conn->insert_id);
        if (!$person) {
            echo "Error: Person ID retrieval failed.";
            return false;
        }

        // if (!DoctorRank::add_doctor_rank($doctor_rank_name)) {
        //     echo "Error: Unable to add doctor rank.";
        //     return false;
        // }
        // $doctor_rank = DoctorRank::get_doctor_rank($conn->insert_id);
        // if (!$doctor_rank) {
        //     echo "Error: Doctor rank retrieval failed.";
        //     return false;
        // }

        // if (!Speciality::add_speciality($doctor_speciality_name)) {
        //     echo "Error: Unable to add doctor specialty.";
        //     return false;
        // }
        // $doctor_speciality = Speciality::get_speciality_by_id($conn->insert_id);
        // if (!$doctor_speciality) {
        //     echo "Error: Specialty retrieval failed.";
        //     return false;
        // }

        $person_id = $person->getId();
        // $doctor_rank_id = $doctor_rank->getId();
        // $doctor_speciality_id = $doctor_speciality->getId();

        $query = "
            INSERT INTO `doctor` (person_id, rank_id, speciality_id) 
            VALUES ('$person_id', '$doctor_rank_id', '$doctor_speciality_id')
        ";

        return run_query($query, true);
    }

    public function update_obeserver(): void {
        // Fetch applications for this doctor
        $applications = self::getApplicationsForDoctor($this->getId());
    
        if (empty($applications)) {
            error_log("No applications found for Doctor ID: {$this->getId()}.");
            return;
        }
    
        // Assign the fetched applications to the doctor's applications property
        $this->applications = $applications;
    
        // Log update for debugging
        error_log("Applications for Doctor ID {$this->getId()} updated.");
    }
    
    
    public static function update(array $array): bool {
        
        if (!isset($array['doctor_id'])) {
            echo "Error: 'id' is required to update a doctor.";
            return false;
        }

        $id = $array['doctor_id'];
      
        if (isset($array['speciality_id'])) {
            $setParts[] = "`speciality_id` = " . intval($array['speciality_id']);
        }
        if (isset($array['rank_id'])) {
            $setParts[] = "`rank_id` = " . intval($array['rank_id']);
        }
        if (isset($array['isAvailable'])) {
            $setParts[] = "`isAvailable` = " . $array['isAvailable'];
        }
        
        if (empty($setParts)) {
            echo "Error: No fields to update.";
            return false;
        }

        $setClause = implode(', ', $setParts);
        
        $query = "UPDATE `doctor` SET $setClause WHERE id = '$id'";
        $status = run_query($query, true);
        Person::update($array);
        return $status;
        
    }

    public static function delete($id): bool {
        // SQL query to update the isDeleted flag to 1
        $query = "UPDATE `person` SET `isDeleted` = 1 WHERE id = '$id'";

        // Execute the query
        return run_query($query, true);
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
    
        $rows = run_select_query($query);
        $applications = [];
    
        if ($rows && $rows->num_rows > 0) {
            while ($row = $rows->fetch_assoc()) {
                $applications[] = new PatientMedicalApplicationModel($row);
            }
        }
    
        return $applications;
    }
    
}
