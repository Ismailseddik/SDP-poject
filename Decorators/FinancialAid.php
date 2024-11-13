<?php

class FinancialAid extends AidTypeDecorator
{
    private float $amountReceived;
    private int $hospitalBankAccountNo;
    private int $receiptNo;

    public function __construct(array $data, $amountReceived, $hospitalBankAccountNo, $receiptNo) {
        parent::__construct($data); // Initialize the base properties from AidTypeModel
        $this->amountReceived = $amountReceived;
        $this->hospitalBankAccountNo = $hospitalBankAccountNo;
        $this->receiptNo = $receiptNo;
    }

    public function provideAidType(): int {
        echo "Providing financial aid with amount: " . $this->amountReceived;
        return 1; // Example return value
    }
}