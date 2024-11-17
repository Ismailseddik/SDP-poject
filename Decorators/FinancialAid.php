<?php

class FinancialAid extends AidTypeDecorator
{
    // private float $amountReceived;
    // private int $hospitalBankAccountNo;
    // private int $receiptNo;

    public function __construct($ref) {
        // parent::__construct($data); // Initialize the base properties from AidTypeModel
        $this->ref = $ref;

    }

    public function provideAidType(): array {
        $arr = $this->ref->provideAidType();
        array_push($arr,1);
        return $arr; // Example return value
    }
}