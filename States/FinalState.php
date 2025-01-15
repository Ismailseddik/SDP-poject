<?php
require_once '../interfaces/IPaymentState.php';
class FinalState implements IPaymentState {
    private $context;

    public function __construct(DonorController $context) {
        $this->context = $context;
    }
    public function ReceiveData($data) {}
    public function DataRejected() {}
    public function CallAPI($data) {}
    public function APICallFailed($data) {}
    public function ResponseRecieved($data) {}
    public function ResponseDisplayed() {
        echo "No further transitions allowed. Workflow has ended.\n";
        $this->context->logMessage("No further transitions allowed. Workflow has ended.");
    }
    public function displayResponse() {
        echo "Current state: NoOpState (Workflow complete).\n";
        $this->context->logMessage("Current state: NoOpState (Workflow complete).");
    }
}
