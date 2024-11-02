<?php
class PatientController {
    public function index() {
        $patients = [
            ['name' => 'John Doe', 'age' => 35, 'condition' => 'Diabetes'],
            ['name' => 'Jane Smith', 'age' => 28, 'condition' => 'Asthma']
        ];
        
        $content = '../views/patientView.php';
        include '../views/layout.php';
    }
}
