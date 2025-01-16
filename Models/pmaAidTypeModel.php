<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");

require_once "Models/pmaAidTypeModel.php";
require_once "Models/aidTypeModel.php";


require_once "Iterator/Iterators.php";


ob_end_clean();

class pmaAidTypeModel extends Iterators{

    private ?int $id;
    private ?int $patient_application_id;
    private ?int $aid_type_id;    


    public function get_id(){return $this->id;}
    public function get_patient_application_id(){return $this->patient_application_id;}
    public function get_aid_type_id(){return $this->aid_type_id;}

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
    
    public static function get_by_patient_application_id($application_id){
        $query= "Select *
                        From patient_medical_aid_application_aid_type
                        where patient_medical_aid_application_aid_type.patient_application_id = '$application_id'";

        $rows = run_select_query($query);
        $pmaAidTypes=[];

        if ($rows && $rows->num_rows > 0) 
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $types[] = new pmaAidTypeModel($itr->Next());
            }
        }
        return $pmaAidTypes;
    }

    // public function provideAidType():array{
    //     return [];
    // }


}