<?php

class ResidentStrategy implements DoctorRankStrategy
{

    public function getDoctorExperience(): string {
        return "Resident: Intermediate experience in their specialty.";
    }

    public function editDoctorCredentials(Doctor $doctor): Doctor {
        // Logic for editing resident credentials
        return $doctor;
    }
}