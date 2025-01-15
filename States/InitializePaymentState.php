<?php
require_once '../interfaces/IPaymentState.php';
class InitializePaymentState implements IPaymentState {
    private $context;

    public function __construct(DonorController $context) {
        $this->context = $context;
    }
    public function ReceiveData($data) {
        if (isset($data['donor_id']) && isset($data['donation_id']) && $data['donor_id'] !== '' && $data['donation_id'] !== '') {
            echo "Data received and validated. Transitioning to Process Payment.\n";
            $this->context->setState(new ProcessPaymentState($this->context));
            $this->context->logMessage("Data received and validated. Transitioning to Process Payment.");
            $this->context->handleTransition('CallAPI', $data); // Next transition
        } else {
            echo "Data validation failed. Calling DataRejected.\n";
            $this->context->logMessage("Data validation failed. Calling DataRejected.");
            $this->DataRejected();
            return; // Stop further execution
        }
    }
    
    public function DataRejected() {
        echo "Data rejected. Resetting to Initialize Payment.\n";
        $this->context->setState(new InitializePaymentState($this->context));
        $this->context->logMessage("Data rejected. Resetting to Initialize Payment..");
    }
    public function CallAPI($data){
        //no implementation needed
    }
    public function APICallFailed($data){
        //no implementation needed
    }
    public function ResponseRecieved($data){
        //no implementation needed
    }
    public function ResponseDisplayed(){
        //no implementation needed
    }
    public function displayResponse() {
        echo "Current state: ProcessPayment\n";
    }
}
