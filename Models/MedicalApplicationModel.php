<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class MedicalApplication{

    private ?int $id;
    private ?int $doctor_id;

    public function __construct(array $data)
    {
       $this->id = $data['application_id'];
       $this->doctor_id = $data['doctor_id'];

    }

    public static function get_all_applications(){

        $query = "
            SELECT
                medical_aid_application.id AS application_id, 
                doctor.id AS doctor_id,
    
            FROM medical_aid_application
            JOIN doctor ON medical_aid_application.doctor_id = doctor.id
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


    public static function get_applicaton_details(int $application_id): MedicalApplication|bool
    {
        $query = "
        SELECT
            medical_aid_application.id AS application_id, 
            doctor.id AS doctor_id,

        FROM medical_aid_application
        JOIN doctor ON medical_aid_application.doctor_id = doctor.id
        WHERE  medical_aid_application.id = '$application_id'
    ";

        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
           return new self($rows->fetch_assoc());
        } else {
            echo "Error: Application with ID $application_id not found.";
           return false;
        }
    }

    public static function add_application(int $doctor_id)
    {
        $query = "
        INSERT INTO `medical_aid_application` (doctor_id) 
        VALUES ('$doctor_id')
    ";

    return run_query($query, true);
        
    }


    


}

