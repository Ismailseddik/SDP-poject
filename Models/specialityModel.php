<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");


ob_end_clean();

class Speciality extends Iterators
{
    private ?int $id;
    private ?String $name;

    public function __construct(array $data)
    {

        $this->id = $data["id"];
        $this->name = $data["speciality_name"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->name <br/>";
        return $str . '</pre>';
    }
    public static function get_speciality_by_id($speciality_id)
    {

        $rows = run_select_query("SELECT * FROM `speciality` WHERE id = '$speciality_id'");
        if ($rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            return false;
        }
    }
    // New method to fetch all specialties
    public static function getAllSpecialties(): array
    {
        $query = "SELECT id, speciality_name FROM speciality";
        $rows = run_select_query($query);
        $specialties = [];
        if ($rows && $rows->num_rows > 0) {
            
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $speciality = $itr->Next();
                $specialties[$speciality['id']] = $speciality['speciality_name']; // Populate id => specialty_name array

            }
        }
        return $specialties;
    }
    public static function get_all_specialites()
    {
        $Specialties = [];
        $rows = run_select_query("SELECT * from `aid_type`");

        if ($rows && $rows->num_rows > 0) 
        {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $Specialties[] = new Speciality($itr->Next());
            }
        }
        return $Specialties;     
    }
    public static function add_speciality($speciality_name): bool
    {

        $query = "INSERT INTO `speciality` (speciality_name) VALUES ('$speciality_name')";

        return run_query($query, true);
    }

}
