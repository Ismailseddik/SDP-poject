<?php
class DoctorController {
    public function index() {
        // Placeholder data
        $doctors = [
            ['name' => 'Dr. Alice Brown', 'specialty' => 'Cardiology', 'available_times' => 'Mon-Fri, 9am-3pm'],
            ['name' => 'Dr. Bob White', 'specialty' => 'Orthopedics', 'available_times' => 'Tue-Thu, 10am-4pm']
        ];

        // Load the view
        $content = '../views/doctorView.php';
        include '../views/layout.php';
    }
}
