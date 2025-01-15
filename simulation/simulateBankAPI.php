<?php
// simulateBankAPI.php
// simulateBankAPI.php
function simulateBankAPIResponse(): array {
    // Simulate random API success or failure
    $isSuccessful = rand(0, 1) === 1; // Randomly decide if the transaction is successful
    $isInsufficientFunds = rand(0, 1) === 1; // Randomly decide if there are insufficient funds

    if (!$isSuccessful && $isInsufficientFunds) {
        return [
            'status' => 'failure',
            'transaction_id' => null, // No transaction ID for failure
            'message' => 'Payment failed due to insufficient funds',
        ];
    } elseif ($isSuccessful) {
        return [
            'status' => 'success',
            'transaction_id' => uniqid('txn_', true),
            'message' => 'Payment processed successfully',
        ];
    } else {
        return [
            'status' => 'failure',
            'transaction_id' => null, // No transaction ID for failure
            'message' => 'Payment failed due to a general error',
        ];
    }
}

