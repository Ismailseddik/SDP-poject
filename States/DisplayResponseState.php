<?php
require_once '../interfaces/IPaymentState.php';
class DisplayResponseState implements IPaymentState {
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
        //no implementation needed
    }
    public function APICallFailed($data){
        //no implementation needed
    }
    public function ResponseRecieved($data){
        //implementation to be done
    }
    public function ResponseDisplayed() {
        echo "Displaying response to the user. Workflow completed.\n";
        $this->context->logMessage("Displaying response to the user. Workflow completed.");
        $this->context->setState(new FinalState($this->context)); // Transition to NoOpState
    }
    public function displayResponse() {
        echo "Current state: DisplayResponse\n";
    }
}
