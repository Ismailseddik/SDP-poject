<?php
class DonorController {
    public function index() {
        // Placeholder data
        $donors = [
            ['name' => 'Anna Johnson', 'email' => 'anna.j@example.com', 'amount' => 200],
            ['name' => 'Mark Lee', 'email' => 'mark.l@example.com', 'amount' => 150]
        ];

        // Load the view
        $content = '../views/donorView.php';
        include '../views/layout.php';
    }
}
