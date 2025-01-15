<?php
interface IPaymentState {
    public function ReceiveData($data);
    public function DataRejected();
    public function CallAPI($data);
    public function APICallFailed($data);
    public function ResponseRecieved($data);
    public function ResponseDisplayed();
    public function displayResponse();
}
