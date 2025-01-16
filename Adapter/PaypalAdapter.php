<?php
require_once 'CreditAdaptee.php';
class PaypalAdapter implements IPayment {
    private ?PaypalAdaptee $paypalAdaptee;

    // Constructor that accepts an instance of CreditAdaptee
    public function __construct(PaypalAdaptee $paypalAdaptee) {
        $this->paypalAdaptee = $paypalAdaptee;
    }

    public function request(): void {
        $this->paypalAdaptee->specifications();
    }
}