<?php
// MedicalApplicationModel.php
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");


class MedicalApplication {

    // Function to add a new application for a patient
    public static function addApplication($patient_id, $doctor_id, $status_id = 1) {
        global $conn;

        // Step 1: Check if the `medical_aid_application` table has any records for this doctor
        $query = "SELECT id FROM medical_aid_application WHERE doctor_id = $doctor_id LIMIT 1";
        $result = run_select_query($query);

        // If `medical_aid_application` is empty, insert a new record
        if (!$result || $result->num_rows === 0) {
            $insertQuery = "INSERT INTO medical_aid_application (doctor_id) VALUES ($doctor_id)";
            if (!run_query($insertQuery)) {
                echo "Error: Unable to create a new medical aid application.";
                return false;
            }

            // Get the newly inserted `application_id`
            $application_id = $conn->insert_id;
        } else {
            // Use the existing `application_id` if found
            $row = $result->fetch_assoc();
            $application_id = $row['id'];
        }

        // Step 2: Insert into `patient_medical_aid_application` using `patient_id`, `application_id`, and `status_id`
        $linkQuery = "INSERT INTO patient_medical_aid_application (patient_id, application_id, status_id) VALUES ($patient_id, $application_id, $status_id)";
        if (!run_query($linkQuery)) {
            echo "Error: Unable to link patient to medical aid application.";
            return false;
        }

        return true;
    }

    public static function getAllApplications(): array
    {
        $query = "
            SELECT 
                ma.id AS application_id,
                CONCAT(p_person.first_name, ' ', p_person.last_name) AS patient_name,
                CONCAT(d_person.first_name, ' ', d_person.last_name) AS doctor_name,
                app_status.status AS status
            FROM 
                medical_aid_application ma
            JOIN 
                patient_medical_aid_application pma ON ma.id = pma.application_id
            JOIN 
                patient p ON pma.patient_id = p.id
            JOIN 
                person p_person ON p.person_id = p_person.id
            JOIN 
                doctor d ON ma.doctor_id = d.id
            JOIN 
                person d_person ON d.person_id = d_person.id
            JOIN 
                application_status app_status ON pma.status_id = app_status.id
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
    
    
    
    

    // Function to get details of a specific application
    public static function getApplicationDetails($application_id) {
        $query = "
            SELECT 
                p.first_name AS patient_name, 
                a.id AS application_id, 
                d.first_name AS doctor_name, 
                s.status AS application_status 
            FROM patient_medical_aid_application pm
            JOIN patient pt ON pm.patient_id = pt.id
            JOIN person p ON pt.person_id = p.id
            JOIN medical_aid_application a ON pm.application_id = a.id
            JOIN doctor d ON a.doctor_id = d.id
            JOIN application_status s ON pm.status_id = s.id
            WHERE a.id = $application_id
        ";

        $result = run_select_query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null; // Return null if no application is found
    }

    // Function to delete an application (optional)
    public static function deleteApplication($application_id) {
        $query = "DELETE FROM patient_medical_aid_application WHERE application_id = $application_id";
        return run_query($query);
    }

    // Function to update the status of an application
    public static function updateApplicationStatus($application_id, $status_id) {
        $query = "UPDATE patient_medical_aid_application SET status_id = $status_id WHERE application_id = $application_id";
        return run_query($query);
    }
}
