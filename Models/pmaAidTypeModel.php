<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
require_once "../Models/pmaAidTypeModel.php";
require_once "../Models/aidTypeModel.php";

ob_end_clean();

class pmaAidTypeModel {
    private ?int $id;
    private ?int $patient_application_id;
    private ?int $aid_type_id;    


    public function get_id(){return $this->id;}
    public function get_patient_application_id(){return $this->patient_application_id;}
    public function get_aid_type_id(){return $this->aid_type_id;}

    public function __construct(array $data) {
        $this->id = isset($data['id']) ? (int) $data['id'] : null;
        $this->patient_application_id = isset($data['patient_application_id']) ? (int) $data['patient_application_id'] : null;
        $this->aid_type_id = isset($data['aid_type_id']) ? (int) $data['aid_type_id'] : null;
    }

    public static function add_entry($patient_application_id, $aid_type_id):bool
    {
        $query = "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`,`aid_type_id`) VALUES ('$patient_application_id','$aid_type_id')";
        return run_query($query, true);
    }
    
    public static function get_by_patient_application_id($application_id){
        $query= "Select *
                        From patient_medical_aid_application_aid_type
                        where patient_medical_aid_application_aid_type.patient_application_id = '$application_id'";

        $rows = run_select_query($query);
        $pmaAidTypes=[];
        foreach($rows->fetch_all(MYSQLI_ASSOC) as $row){
            $pmaAidTypes[] = new pmaAidTypeModel($row);
            
        }
        return $pmaAidTypes;
    }
    public static function remove_entry(int $applicationId, int $aidTypeId): bool {
        $query = "DELETE FROM patient_medical_aid_application_aid_type 
                  WHERE patient_application_id = '$applicationId' AND aid_type_id = '$aidTypeId'";
        return run_query($query, true);
    }
    
    public static function check_patient_application_exists($patientApplicationId): bool {
        $query = "SELECT COUNT(*) as count FROM patient_medical_aid_application WHERE id = '$patientApplicationId'";
        $result = run_select_query($query);
        return $result && $result->fetch_assoc()['count'] > 0;
    }
    
    // public function provideAidType():array{
    //     return [];
    // }


}