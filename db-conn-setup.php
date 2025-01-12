<?php
class DataBase{

    static private $instance = null;
    private $conn;
    static public function getInstance(): DataBase
    {
        if (self::$instance == null) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $configs = require "config.php";
        // Ensure the correct database name and port are selected
        $this->conn = new mysqli($configs->DB_HOST, $configs->DB_USER, $configs->DB_PASS, $configs->DB_NAME, $configs->DB_PORT);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connected successfully<br/><hr/>";
    }

    public function getConn(): mysqli
    {
        return $this->conn;
    }
}

// Function to run multiple queries
function run_queries($queries, $echo = false): array|mysqli_result
{
    $conn=DataBase::getInstance()->getConn();

    $ret = [];
    foreach ($queries as $commandquery) {
        $ret += [$conn->query($commandquery)];
        if ($echo) {
            echo '<pre>' . $commandquery . '</pre>';
            echo $ret[array_key_last($ret)] === TRUE ? "Query ran successfully<br/>" : "Error: " . $conn->error;
            echo "<hr/>";
        }
    }
    return $ret;
}

// Function to run a single query
function run_query($commandquery, $echo = false): bool|array|mysqli_result
{
    return run_queries([$commandquery], $echo)[0];
}

// Function to run a select query and return result
function run_select_query($commandquery, $echo = false): mysqli_result|bool
{
    $conn=DataBase::getInstance()->getConn();

    $result = $conn->query($commandquery);
    if ($echo) {
        echo '<pre>' . $commandquery . '</pre>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                echo $row;
        } else {
            echo "0 results";
        }
        echo "<hr/>";
    }
    return $result;
}

function does_exist($query):bool{
   if (!(bool)run_select_query($query,false)->num_rows){
        echo "This ID does not even exist in the database ";
        return false;
   }
   return true;
}

function table_exist($table_name):bool{
    // because 'like' takes string we put the name between qutations
    $query = "SHOW TABLES LIKE '$table_name'"; 
    $result = run_query($query);

    if ($result->num_rows > 0) {return true;}

    echo "The Table: '$table_name' does not even exist in the Datbase";
    return false;
}
function column_exist($table_name, $column_name):bool
{
    if(!table_exist($table_name)){return false;}
    
    // here we did not put quotes on $table_name because it not meant to be read as string 
    $query = "SHOW COLUMNS FROM $table_name"; 
    $result = run_query($query);

    while($row = $result->fetch_assoc()) 
    {
        if($row['Field'] == $column_name){return true;}
    }
    echo "The column: '$column_name', does not Exist in the Table: '$table_name'";
    return false;
    

}
