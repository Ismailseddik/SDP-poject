<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");

require_once "pmaAidTypeModel.php";
require_once "aidTypeModel.php";


include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");


ob_end_clean();

class pmaAidTypeModel extends Iterators{

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

    public static function Read_All()
    {   
        $PmaAidTpes = []; 
        $rows = run_select_query("SELECT * FROM `patient_medical_aid_application_aid_type`");
        if ($rows->num_rows > 0) 
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext()) 
            {
                $PmaAidTpes[] = new pmaAidTypeModel($itr->Next());
            }        
        } 
        else 
        {
            return false;
        }

        return $PmaAidTpes;
    }
    public static function Read($id)
    {
        $query = "SELECT * FROM `patient_medical_aid_application_aid_type` WHERE id = '$id'";


        
        $rows = run_select_query($query);
        return new self($rows->fetch_assoc());

    }

    public static function add_entry($patient_application_id, $aid_type_id):bool
    {
        $query = "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`,`aid_type_id`) VALUES ('$patient_application_id','$aid_type_id')";
        return run_query($query, true);
    }
    
    public static function Update($array): bool
    {

        $query = "UPDATE `patient_medical_aid_application_aid_type` SET `patient_application_id` = '$array[1]', `aid_type_id` = '$array[2]'   WHERE `id` ='$array[0]'";
        
        return run_query($query, true);
    }

    public static function remove_entry(int $applicationId, int $aidTypeId): bool {
        $query = "DELETE FROM patient_medical_aid_application_aid_type 
                  WHERE patient_application_id = '$applicationId' AND aid_type_id = '$aidTypeId'";
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
                $pmaAidTypes[] = new pmaAidTypeModel($itr->Next());
            }
        }
        return $pmaAidTypes;
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