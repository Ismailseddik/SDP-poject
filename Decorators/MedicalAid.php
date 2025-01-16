<?php

class MedicalAid extends AidTypeDecorator
{
    // private string $medicineType;

    public function __construct(pmaAidTypeModel $ref) {
        $this->ref = $ref;
        //$this->WrapAidType();
    }

    public function WrapAidType() {
        try{
            pmaAidTypeModel::add_entry($this->ref->get_patient_application_id(),2);
        } catch(Exception $e){
            echo "Error:".$e->getMessage();
        }
    }
    // public function provideAidType(): array {
    //     $arr = $this->ref->provideAidType();
    //     array_push($arr,2);
    //     return $arr; // Example return value
    // }
}