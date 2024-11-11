<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class Speciality
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
    public static function add_speciality($speciality_name): bool
    {

        $query = "INSERT INTO `speciality` (speciality_name) VALUES ('$speciality_name')";

        return run_query($query, true);
    }
}
