<?php
//Db Connection
require('../../config/db_connection.php');
//Get data from register form

$email=$_POST['email'];
$pass=$_POST['passwd'];

//encrypt password using md5 hash algorithm
$enc_pass = md5($pass);

$query = "insert into users (email, password) 
values('$email', '$enc_pass')";

$result = pg_query($conn, $query);

if($result){
    echo "Registration Successful!";
}else{echo "Registration Failure";}

pg_close($conn);
?>