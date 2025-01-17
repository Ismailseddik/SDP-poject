<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
require_once 'MedicalApplicationModel.php';
require_once 'applicationStatusModel.php';
require_once 'doctorModel.php';

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "\Observers\IObserver.php");

ob_end_clean();
  // id | typeid | patient_medical id | 
class PatientMedicalApplicationModel extends Iterators{

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

            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $applications[] = $itr->Next();
            }
        }
        return $applications;
    }

    // weird implementation!!!!!!!
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
                application_status.id AS status_id,
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

        $result = run_select_query($query);

        // Check if the query returned any results
        if ($result && $result->num_rows > 0) {
            $applications = [];
            while ($row = $result->fetch_assoc()) {
                // Create a new instance for each row and add it to the applications array
                $applications[] = new self($row);
            }
            return $applications;
        }

        return false; // Return false if no applications are found
    }

    // public static function add_aid_types(int $application_id, array $aid_types): bool {
    //     foreach ($aid_types as $aid_type_id) {
    //         $query = "INSERT INTO `patient_medical_aid_application` (application_id, aid_type_id, status_id)
    //                   VALUES ('$application_id', '$aid_type_id', 1)";
    //         if (!run_query($query, true)) {
    //             error_log("Error: Unable to insert aid type ID $aid_type_id for application ID $application_id.");
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    
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
    public function getApplicationStatus(): string|null {
        return $this->application_status;
    }
    public static function update($array): bool
    {   
        $status_id = $array['status_id'];
        $patient_application_id = $array['patient_application_id'];
        $query = "UPDATE `patient_medical_aid_application` SET status_id = '$status_id' WHERE id = '$patient_application_id' ";

        return run_query($query, true);
    }
    public static function delete($patient_application_id): bool
    {
        $query = "DELETE FROM `patient_medical_aid_application` WHERE id = '$patient_application_id'";
        return run_query($query, true);
    }

}