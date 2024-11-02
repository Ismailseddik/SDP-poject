<?php
class MedicalApplicationController {
    public function index() {
        // Placeholder data
        $applications = [
            ['patient_name' => 'John Doe', 'condition' => 'Diabetes', 'aid_type' => 'Financial Aid'],
            ['patient_name' => 'Jane Smith', 'condition' => 'Asthma', 'aid_type' => 'Medical Aid']
        ];

        // Load the view
        $content = '../views/medicalApplicationView.php';
        include '../views/layout.php';
    }
}
