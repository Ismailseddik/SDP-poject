<?php

interface DoctorRankStrategy
{
    public function getDoctorExperience(): string;
    public function editDoctorCredentials(Doctor $doctor): Doctor;
}