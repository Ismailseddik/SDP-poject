<?php

class InternStrategy implements DoctorRankStrategy
{

    public function getDoctorExperience(): string {
        return "Intern: Basic training and introductory experience.";
    }

    public function editDoctorCredentials(Doctor $doctor): Doctor {
        // Logic for editing intern credentials
        return $doctor;
    }
}