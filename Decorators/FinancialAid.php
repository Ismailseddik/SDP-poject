<?php

class FinancialAid extends AidTypeDecorator
{
    // private float $amountReceived;
    // private int $hospitalBankAccountNo;
    // private int $receiptNo;

    public function __construct(pmaAidTypeModel $ref) {
        // parent::__construct($data); // Initialize the base properties from AidTypeModel
        $this->ref = $ref;
        $this->WrapAidType();
    }

    public function WrapAidType() {
        try{
            pmaAidTypeModel::add_entry($this->ref->get_patient_application_id(),1);
        } catch(Exception $e){
            echo "Error:".$e->getMessage();
        }
    }

    // public function provideAidType(): array {

        
    //     $arr = $this->ref->provideAidType();
    //     array_push($arr,1);
    //     return $arr; // Example return value
    // }
}