<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class Doctor
{
    private ?String $specialty;
    //private ?String $last_name;

    static public function get_all(): array
    {
        //To be implemented
        return [];
    }

    //Get Doctor object by id or return NULL
    static public function get_by_id($id): Doctor|null
    {
        //To be implemented
        return NULL;
    }
    public function addDoctor($fname, $lname, $specialty, $available_times, $birth_date): bool
    {
        //To be implemented
        return false;
    }
}
