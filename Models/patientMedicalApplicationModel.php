<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
require_once 'Models/medicalApplicationModel.php';
ob_end_clean();


/*CREATE TABLE `patient_medical_aid_application` (
    `id` int(11) NOT NULL,
    `patient_id` int(11) NOT NULL,
    `application_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;*/
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

    // Getters
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

        $result = run_select_query($query);

        if ($result && $result->num_rows > 0) {
            return new self($result->fetch_assoc());
        }

        return false; 
    }

    // Add a patient-application relationship
    public static function add_patient_application(int $patient_id,int $doctor_id): bool
    {
        global $conn;

        if (!MedicalApplication::add_application($doctor_id)) {
            echo "Error: Unable to add application record.";
            return false;
        }
        $application_id=$conn->insert_id;
        $query = "INSERT INTO patient_medical_aid_application (patient_id, application_id) VALUES ('$patient_id', '$application_id')";
        return run_query($query, true);
    }
}