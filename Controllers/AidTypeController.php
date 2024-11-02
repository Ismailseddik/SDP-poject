<?php
class AidTypeController {
    public function index() {
        // Placeholder data
        $aidTypes = [
            ['name' => 'Financial Aid', 'description' => 'Covers the cost of medical operations.'],
            ['name' => 'Medical Aid', 'description' => 'Provides essential medication that is unavailable.']
        ];

        // Load the view
        $content = '../views/aidTypeView.php';
        include '../views/layout.php';
    }
}
