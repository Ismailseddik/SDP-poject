<?php
class DonationController {
    public function index() {
        // Placeholder data
        $donations = [
            ['id' => 1, 'amount' => 100, 'donor_name' => 'Anna Johnson'],
            ['id' => 2, 'amount' => 150, 'donor_name' => 'Mark Lee']
        ];

        // Load the view
        $content = '../views/donationView.php';
        include '../views/layout.php';
        
    }
}
