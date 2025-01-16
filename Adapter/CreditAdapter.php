<?php
require_once 'CreditAdaptee.php';
class CreditAdapter implements IPayment {
    private ?CreditAdaptee $creditAdaptee;

    // Constructor that accepts an instance of CreditAdaptee
    public function __construct(CreditAdaptee $creditAdaptee) {
        $this->creditAdaptee = $creditAdaptee;
    }

    public function request(): void {
        $this->creditAdaptee->specifications();
    }
}