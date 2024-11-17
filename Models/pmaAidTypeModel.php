<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");
ob_end_clean();

class pmaAidTypeModel{
    private ?int $id;
    private ?int $patient_application_id;
    private ?int $aid_type_id;	


    public function __construct(array $data){
        $this->id = $data['id'] ?? null;
        $this->id = $data['patient_application_id'] ?? null;
        $this->id = $data['aid_type_id'] ?? null;
    }






}




