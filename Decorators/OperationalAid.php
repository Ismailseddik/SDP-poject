<?php

class OperationalAid extends AidTypeDecorator
{
    public function __construct(pmaAidTypeModel $ref) {
        $this->ref = $ref;
        $this->WrapAidType();
    }

    public function WrapAidType() {
        try{
            pmaAidTypeModel::add_entry($this->ref->get_patient_application_id(),3);
        } catch(Exception $e){
            echo "Error:".$e->getMessage();
        }
    }
    // public function provideAidType(): array {
    //     $arr = $this->ref->provideAidType();
    //     array_push($arr,3);
    //     return $arr; // Example return value
    // }

}