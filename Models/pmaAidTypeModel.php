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

    public function get_id(){
        return $this->id;
    }
    public function get_patient_application_id(){
        return $this->patient_application_id;
    }
    public function get_aid_type_id(){
        return $this->aid_type_id;
    }
    

    public static function add_entry($patient_application_id, $aid_type_id):bool
    {
        $query = "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`,`aid_type_id`) VALUES ('$patient_application_id','$aid_type_id')";
        return run_query($query, true);
    }
    public static function get_objects_by_application_id($application_id):array{

        $query= "Select *
                        From patient_medical_aid_application_aid_type
                        where patient_medical_aid_application_aid_type.patient_application_id = '$application_id'";
        $pmaAidTypeObjects = [];
        $rows = run_select_query($query);

        if (!$rows) {
            echo "Error: Query execution failed in get_objects_by_application_id.\n";
            return [];
        } elseif ($rows->num_rows === 0) {
            echo "Debug: Query executed but returned no results in get_objects_by_application_id.\n";
        } else {
            echo "Debug: Query successful, fetching pmaAidTypeObjects in get_objects_by_application_id.\n";
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $pmaAidTypeObjects[] = new pmaAidTypeModel($row);
            }
        }
        return $pmaAidTypeObjects;
    }
    public static function get_aidtypes_by_application_id($application_id):array{
        $query= "Select patient_medical_aid_application_aid_type.aid_type_id
                        From patient_medical_aid_application_aid_type
                        where patient_medical_aid_application_aid_type.patient_application_id = '$application_id'";

        $rows = run_select_query($query);
        $Aid_types=[];
        foreach($rows->fetch_all(MYSQLI_ASSOC) as $row){
            // print_r($row);
            $aid_type_obj = AidTypeModel::get_aid_type($row["aid_type_id"]);
            // pushing only the name of the aid type without the id
            array_push($Aid_types,$aid_type_obj->getType());
        }
        return $Aid_types;
    }

    

    // public function provideAidType():array{
    //     return [];
    // }


}