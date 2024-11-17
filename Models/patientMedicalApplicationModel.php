<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
require_once 'MedicalApplicationModel.php';
ob_end_clean();

class PatientMedicalApplicationModel{
    private ?int $id;
    private ?int $patient_id;
    private ?int $application_id;
    private ?string $patient_first_name;
    private ?string $patient_last_name;
    private ?string $doctor_first_name;
    private ?string $doctor_last_name;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->patient_id = $data['patient_id'] ?? null;
        $this->application_id = $data['application_id'] ?? null;
        $this->patient_first_name = $data['patient_first_name'] ?? null;
        $this->patient_last_name = $data['patient_last_name'] ?? null;
        $this->doctor_first_name = $data['doctor_first_name'] ?? null;
        $this->doctor_last_name = $data['doctor_last_name'] ?? null;
    }

    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "patient_id: $this->patient_id <br/>";
        $str .= "application_id: $this->application_id<br/>";
        $str .= "patient_first_name: $this->patient_first_name<br/>";
        $str .= "patient_last_name: $this->patient_last_name<br/>";
        $str .= "doctor first name:  $this->doctor_first_name ";
         $str .= "doctor last name:$this->doctor_last_name";

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
                person_doctor.last_name AS doctor_last_name
            FROM patient_medical_aid_application
            JOIN medical_aid_application ON patient_medical_aid_application.application_id = medical_aid_application.id
            JOIN doctor ON medical_aid_application.doctor_id = doctor.id
            JOIN patient ON patient_medical_aid_application.patient_id = patient.id
            JOIN person AS person_patient ON patient.person_id = person_patient.id
            JOIN person AS person_doctor ON doctor.person_id = person_doctor.id
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
                person_doctor.last_name AS doctor_last_name
            FROM patient_medical_aid_application
            JOIN medical_aid_application ON patient_medical_aid_application.application_id = medical_aid_application.id
            JOIN doctor ON medical_aid_application.doctor_id = doctor.id
            JOIN patient ON patient_medical_aid_application.patient_id = patient.id
            JOIN person AS person_patient ON patient.person_id = person_patient.id
            JOIN person AS person_doctor ON doctor.person_id = person_doctor.id
            WHERE patient_medical_aid_application.patient_id = '$patient_id'
        ";
        // id x | patient id x | id(patient) | person_id | id(person) | first name x | last name x | address id | birth date | is deleted | application id x | doctor id | id(doc) | person_id |  id(person) | first name x | last name x | address id | birth date | is deleted  | speciality id | rank id | isAvailable | status id |
        $result = run_select_query($query);

        if ($result && $result->num_rows > 0) {
            return new self($result->fetch_assoc());
        }

        return false; 
    }

    public static function add_patient_application(int $patient_id,int $doctor_id): bool
    {
        $conn=DataBase::getInstance()->getConn();
        $status_id=1;
        if (!MedicalApplication::add_application($doctor_id)) {
            echo "Error: Unable to add application record.";
            return false;
        }
        $application_id=$conn->insert_id;
        $query = "INSERT INTO `patient_medical_aid_application` (patient_id, application_id, status_id) VALUES ('$patient_id', '$application_id', '$status_id')";
        return run_query($query, true);
    }
}