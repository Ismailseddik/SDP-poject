<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once 'MedicalApplicationModel.php';
require_once 'doctorModel.php';
include_once($_SERVER["DOCUMENT_ROOT"] . "\Observers\IObserver.php");
ob_end_clean();
  // id | typeid | patient_medical id | 
class PatientMedicalApplicationModel{
    private ?int $id;
    private ?int $patient_id;
    private ?int $application_id;
    private ?String $patient_first_name;
    private ?String $patient_last_name;
    private ?String $doctor_first_name;
    private ?String $doctor_last_name;
    private ?String $application_status;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->patient_id = $data['patient_id'] ?? null;
        $this->application_id = $data['application_id'] ?? null;
        $this->patient_first_name = $data['patient_first_name'] ?? null;
        $this->patient_last_name = $data['patient_last_name'] ?? null;
        $this->doctor_first_name = $data['doctor_first_name'] ?? null;
        $this->doctor_last_name = $data['doctor_last_name'] ?? null;
        $this->application_status = $data['status'] ?? null;
    }

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "patient_id: $this->patient_id <br/>";
        $str .= "application_id: $this->application_id<br/>";
        $str .= "patient_first_name: $this->patient_first_name<br/>";
        $str .= "patient_last_name: $this->patient_last_name<br/>";
        $str .= "doctor first name:  $this->doctor_first_name<br/>";
        $str .= "doctor last name: $this->doctor_last_name<br/>";
        $str .= "Application Status: $this->application_status<br/>";
        return $str . '</pre>';
    }
    public function getId() { return $this->id; }
    public function getPatientId() { return $this->patient_id; }
    public function getApplicationId() { return $this->application_id; }
    public function getPatientFirstName() { return $this->patient_first_name; }
    public function getPatientLastName() { return $this->patient_last_name; }
    public function getDoctorFirstName() { return $this->doctor_first_name; }
    public function getDoctorLastName() { return $this->doctor_last_name; }

    public static function get_all_applications(): array|bool
    {
        $query = "
            SELECT 
                patient_medical_aid_application.id,
                patient_medical_aid_application.patient_id,
                patient_medical_aid_application.application_id,
                person_patient.first_name AS patient_first_name,
                person_patient.last_name AS patient_last_name,
                person_doctor.first_name AS doctor_first_name,
                person_doctor.last_name AS doctor_last_name,
                application_status.status
            FROM patient_medical_aid_application
            JOIN medical_aid_application ON patient_medical_aid_application.application_id = medical_aid_application.id
            JOIN doctor ON medical_aid_application.doctor_id = doctor.id
            JOIN patient ON patient_medical_aid_application.patient_id = patient.id
            JOIN person AS person_patient ON patient.person_id = person_patient.id
            JOIN person AS person_doctor ON doctor.person_id = person_doctor.id
            JOIN application_status ON patient_medical_aid_application.status_id = application_status.id
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
    public static function get_applications_by_patient(int $patient_id): PatientMedicalApplicationModel|bool
    {
        $query = "
            SELECT 
                patient_medical_aid_application.id,
                patient_medical_aid_application.patient_id,
                patient_medical_aid_application.application_id,
                person_patient.first_name AS patient_first_name,
                person_patient.last_name AS patient_last_name,
                person_doctor.first_name AS doctor_first_name,
                person_doctor.last_name AS doctor_last_name,
                application_status.status
            FROM patient_medical_aid_application
            JOIN medical_aid_application ON patient_medical_aid_application.application_id = medical_aid_application.id
            JOIN doctor ON medical_aid_application.doctor_id = doctor.id
            JOIN patient ON patient_medical_aid_application.patient_id = patient.id
            JOIN person AS person_patient ON patient.person_id = person_patient.id
            JOIN person AS person_doctor ON doctor.person_id = person_doctor.id
            JOIN application_status ON patient_medical_aid_application.status_id = application_status.id
            WHERE patient_medical_aid_application.patient_id = '$patient_id'
        ";
      
        
        // id x | patient id x | id(patient) | person_id | id(person) | first name x | last name x | address id | birth date | is deleted | application id x | doctor id | id(doc) | person_id |  id(person) | first name x | last name x | address id | birth date | is deleted  | speciality id | rank id | isAvailable | status id |
        $result = run_select_query($query);

        if ($result && $result->num_rows > 0) {
            return new self($result->fetch_assoc());
        }

        return false; 
    }
    public static function add_aid_types(int $application_id, array $aid_types): bool {
        foreach ($aid_types as $aid_type_id) {
            $query = "INSERT INTO `patient_medical_aid_application` (application_id, aid_type_id, status_id)
                      VALUES ('$application_id', '$aid_type_id', 1)";
            if (!run_query($query, true)) {
                error_log("Error: Unable to insert aid type ID $aid_type_id for application ID $application_id.");
                return false;
            }
        }
        return true;
    }
    public static function get_aid_types(int $application_id): array {
        $query = "
            SELECT 
                aid_type.type AS aid_type_name
            FROM 
                patient_medical_aid_application
            JOIN 
                aid_type ON patient_medical_aid_application.aid_type_id = aid_type.id
            WHERE 
                patient_medical_aid_application.application_id = '$application_id'
        ";
    
        $result = run_select_query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public static function add_patient_application(int $patient_id, int $doctor_id): bool {
        $conn = DataBase::getInstance()->getConn();
        $status_id = 1;
    
        if (!MedicalApplication::add_application($doctor_id)) {
            error_log("Error: Unable to add application record.");
            return false;
        }
    
        $application_id = $conn->insert_id;
        $query = "INSERT INTO `patient_medical_aid_application` (patient_id, application_id, status_id) 
                  VALUES ('$patient_id', '$application_id', '$status_id')";
    
        $result = run_query($query, true);
    
    
        return $result;
    }
    
    

}