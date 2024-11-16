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
function run_queries($queries, $echo = false): array
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
function run_query($commandquery, $echo = false): bool
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

