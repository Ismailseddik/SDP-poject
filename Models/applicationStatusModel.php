<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_clean();

class ApplicationStatusModel{

    private ?int $id;
    private ?String $status;

    public function __construct(array $data){

        $this->id = $data["id"];
        $this->status = $data["status"];
    }
    public function getId(): ?int{
        return $this->id;
    }

    public function __toString()
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Application Status: $this->status <br/>";
        return $str . '</pre>';
    }
    public static function get_status_by_id($status_id){

        $rows= run_select_query("SELECT * FROM `status` WHERE id = '$status_id'");
        if($rows->num_rows > 0){
            return new self($rows->fetch_assoc());
        }else{
            return false ;
        }

    }  
    public static function add_status($status): bool
    {
    $query = "INSERT INTO `status` ('status') VALUES ('$status')";
    
    return run_query($query, true);
    
    }

}
