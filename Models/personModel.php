<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();

class Person{

    private ?int $id;
    private ?String $first_name;
    private ?String $last_name;
    private ?DateTime $birth_date;
    private ?int $address_id;
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->birth_date = isset($data['birth_date']) ? new DateTime($data['birth_date']): null;
        $this->address_id = $data['address_id'];
    }


    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "First Name: $this->first_name <br/>";
        $str .= "Last Name: $this->last_name<br/>";
        $str .= "Date of Birth: " . ($this->birth_date? $this->birth_date->format('Y-m-d') : 'N/A') . "<br/>";
        $str .= "Address_ID: $this->address_id<br/>";
        
        return $str . '</pre>';
    }
    public static function get_person_by_id($person_id){
        $rows= run_select_query("SELECT * FROM `person` WHERE id = '$person_id'");
        if($rows->num_rows > 0){
            return new self($rows->fetch_assoc());
        }else{
            return null ;
        }

}

}