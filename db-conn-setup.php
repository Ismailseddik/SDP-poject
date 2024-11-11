<?php
$configs = require "config.php";
$conn = new mysqli($configs->DB_HOST, $configs->DB_USER,$configs -> DB_PASS, $configs->DB_NAME, $configs->DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully<br/><hr/>";

function run_queries($queries, $echo = false): array
{
    global $conn;
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
//checks if the query ran successfully or not
function run_query($commandquery, $echo = false): bool
{
    return run_queries([$commandquery], $echo)[0];
}
// runs a select query and returns an object of the table you want to access the data like $row['first_name'];
function run_select_query($commandquery, $echo = false): mysqli_result|bool
{
    global $conn;
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

// function run_add_query($commandquery, $echo = false): bool
// {
//     global $conn;
//     $result = $conn->query($commandquery);

//     if ($echo) {
//         echo '<pre>' . $commandquery . '</pre>';
//         echo $result === TRUE ? "Record added successfully<br/>" : "Error: " . $conn->error;
//         echo "<hr/>";
//     }

//     return $result === TRUE;
// }

// $conn->close();



// $sqlFile = 'C:\Users\Tarek\OneDrive\Desktop\SDP-poject\mydb.sql';
// $sql = file_get_contents($sqlFile);

// // Split SQL commands by semicolon
// $sqlCommands = explode(';', $sql);

// 
// foreach ($sqlCommands as $command) {
//     $command = trim($command);
//     if (!empty($command)) {
//         if ($conn->query($command) === TRUE) {
//             echo "Query executed successfully:\n";
//             echo '<pre>' . $command . '</pre>';
//             echo "<hr/>";
//         } else {
//             echo "Error executing query: " . $conn->error . "\n";
//         }
//     }
// }

// function returnConnection()
// {
//    $host="localhost";
//      $username="root";
//      $password="";
//      $db_name="macsdb";
// $conn = new mysqli($host, $username, $password,$db_name,3307);

//   return $conn;

// }
// Close the connection
