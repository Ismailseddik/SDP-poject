<?php
require_once '../interfaces/IPaymentState.php';
require_once '../simulation/simulateBankAPI.php'; 
class ProcessPaymentState implements IPaymentState {
    private $context;

    public function __construct(DonorController $context) {
        $this->context = $context;
    }

    public function ReceiveData($data){
        //implementation not needed
    }
    public function DataRejected(){
        echo "Data rejected. Resetting to Initialize Payment.\n";
        $this->context->setState(new InitializePaymentState($this->context));
        $this->context->logMessage("Data rejected. Resetting to Initialize Payment..");
    }
    public function CallAPI($data) {
        // Call the simulateBankAPIResponse function directly
        $response = simulateBankAPIResponse();
    
        // Validate and process the response
        if (isset($response['status']) && $response['status'] === 'success') {
            // Successful API call
            echo "<!-- API call successful -->\n";
            $data['transactionId'] = $response['transaction_id']; // Pass transaction ID to the next state
            $this->context->setState(new RecieveResponseState($this->context));
            $this->context->logMessage("API call successful: " . $response['message']);
            $this->context->handleTransition('ResponseRecieved', $data); // Transition to RecieveResponseState
        } elseif (isset($response['status']) && $response['status'] === 'failure') {
            // Handle failure with specific checks for the message
            if (strpos($response['message'], 'insufficient funds') !== false) {
                echo "<!-- API call failed: Insufficient funds -->\n";
                $this->context->logMessage("API call failed: " . $response['message']);
                $this->DataRejected(); // Reset workflow for insufficient funds
            } else {
                echo "<!-- API call failed: General error -->\n";
                $this->context->logMessage("API call failed: " . $response['message']);
                $this->APICallFailed($data); // Retry logic for other failures
            }
        } else {
            // Invalid response handling
            echo "<!-- API call failed: Invalid response format -->\n";
            $this->context->logMessage("API call failed: Invalid response format.");
            $this->APICallFailed($data); // Retry or reset
        }
    }
    
    
    
    public function APICallFailed($data) {
        static $retryCount = 0;
        $retryCount++;
        if ($retryCount < 3) { // Retry limit
            echo "API call failed. Retrying ($retryCount)...\n";
            $this->context->logMessage("API call failed. Retrying ($retryCount)...");
            $this->CallAPI($data);
        } else {
            echo "API call failed after multiple retries. Resetting to Initialize Payment.\n";
            $this->context->logMessage("API call failed after multiple retries. Resetting to Initialize Payment.");
            $this->context->setState(new InitializePaymentState($this->context));
            $retryCount = 0;
        }
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
