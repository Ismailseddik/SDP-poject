<?php
require_once '../interfaces/IPaymentState.php';
class RecieveResponseState implements IPaymentState {
    private $context;

    public function __construct(DonorController $context) {
        $this->context = $context;
    }
    public function ReceiveData($data){
        //no implementation needed
    }
    public function DataRejected(){
        //no implementation needed
    }
    public function CallAPI($data){
        //implementation to be done
    }
    public function APICallFailed($data) {
        echo "API call failed during response handling. Returning to Process Payment.\n";
        $this->context->logMessage("API call failed during response handling. Returning to Process Payment.\n");
        $this->context->setState(new ProcessPaymentState($this->context));
    }
    public function ResponseRecieved($data) {
        if (!empty($data['transactionId'])) {
            echo "Response received from API. Transitioning to Display Response.\n";
            $this->context->setState(new DisplayResponseState($this->context));
            $this->context->logMessage("Response received from API. Transitioning to Display Response.\n");
            $this->context->handleTransition('ResponseDisplayed', $data); // Next transition
        } else {
            echo "Invalid response. Staying in RecieveResponseState.\n";
            $this->context->logMessage("Invalid response. Staying in RecieveResponseState.\n");
        }
    }    
    public function ResponseDisplayed(){
        //no implementation needed
    }
    public function displayResponse() {
        echo "Current state: RecieveResponse\n";
    }
}
