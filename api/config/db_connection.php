<?php
/*
Database connection
developer: David
*/  

$servername = "localhost";//127.0.0.1
$username = "postgres";
$password = "unicesmag";
$dbname = "beta";
$port = "5432";

$data_connection = "
host = $servername 
port = $port
 user = $username
 password = $password
 dbname = $dbname

";
$conn = pg_connect($data_connection);

if (!$conn) {
    die("Connection failed: ". pg_last_error());
}else{
    echo "connected successfully"; }

//pg_close($conn);

?>