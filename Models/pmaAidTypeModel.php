<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
ob_end_clean();

class pmaAidTypeModel {
    private ?int $id;
    private ?int $patient_application_id;
    private ?int $aid_type_id;    


    public function __construct(array $data){
        $this->id = $data['id'] ?? null;
        $this->patient_application_id = $data['patient_application_id'] ?? null;
        $this->aid_type_id = $data['aid_type_id'] ?? null;
    }

    public static function add_entry($patient_application_id, $aid_type_id):bool
    {
        $query = "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`,`aid_type_id`) VALUES ('$patient_application_id','$aid_type_id')";
        return run_query($query, true);
    }
    
    public static function get_aidtypes_by_application_id($application_id):array{
        $query= "Select patient_medical_aid_application_aid_type.aid_type_id
                        From patient_medical_aid_application_aid_type
                        where patient_medical_aid_application_aid_type.patient_application_id = '$application_id'";

        $rows = run_select_query($query);
        $opertions=[];
        foreach($rows->fetch_all(MYSQLI_ASSOC) as $row){
            // print_r($row);
            $aid_type_obj = AidTypeModel::get_aid_type($row["aid_type_id"]);
            array_push($opertions,$aid_type_obj->getType());
        }
        return $opertions;
    }

    public function provideAidType():array{
        return [];
    }


}