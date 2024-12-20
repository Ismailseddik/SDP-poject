<?php
ob_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");
ob_end_clean();
class AidTypeModel{

    private ?int $id;
    private ?String $type;

    public function __construct(array $data){

    // value(data) = array[key(column)]
    $this->id = $data['id'];
    $this->type = $data['type']; 
    }
    public function getId(): ?int{
        return $this->id;
    }
    public function getType():?string{
        return $this->type;
    }
    public function __toString(): string
    {
        $str = '<pre>';
        $str .= "ID: $this->id<br/>";
        $str .= "Aid Type: $this->type<br/>";
        return $str . '</pre>';
    }

    public static function get_aid_type($aid_id): bool|AidTypeModel{
        $rows= run_select_query("SELECT * FROM `aid_type` WHERE id = '$aid_id'");
        if($rows->num_rows > 0){
            return new self($rows->fetch_assoc());
        }else{
            return false ;
        }

    }  
    public static function get_all_types():array
    {
        $rows = run_select_query("SELECT * from `aid_type` ");
        $types = [];
        foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
            $types[] = new AidTypeModel($row);
        }
        return $types;     
    }
    public static function add_aid_type($type): bool
    {
    $query = "INSERT INTO `aid_type` (`type`)
              VALUES ('$type')";
    
    return run_query($query, true);
    }

    public static function update_aid_type($aid_id,$type): bool
    {
    $query = "UPDATE `aid_type` SET `type` = '$type' WHERE id = '$aid_id' ";
           
    return run_query($query, true);
    }
    public static function delete_aid_type($aid_id): bool{
        
    $query = "DELETE FROM `aid_type` WHERE id = '$aid_id'";
        return run_query($query, true);

        
    }
}