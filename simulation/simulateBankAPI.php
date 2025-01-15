<?php
// simulateBankAPI.php
function simulateBankAPIResponse(): array {
    // Simulate random API success or failure
    return [
        'status' => rand(0, 1) ? 'success' : 'failure',
        'transaction_id' => uniqid('txn_', true),
        'message' => rand(0, 1) ? 'Payment processed successfully' : 'Payment failed due to insufficient funds',
    ];
}
