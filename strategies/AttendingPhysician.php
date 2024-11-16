<?php

class AttendingPhysician implements DoctorRankStrategy
{
    public function getDoctorExperience(): string {
        return "Attending Physician: Advanced experience and responsibility.";
    }

    public function editDoctorCredentials(Doctor $doctor): Doctor {
        // Logic for editing attending physician credentials
        return $doctor;
    }
}