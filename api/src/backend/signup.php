<?php
//Db Connection
require('../../config/db_connection.php');
//Get data from register form

$email=$_POST['email'];
$pass=$_POST['passwd'];

//encrypt password using md5 hash algorithm
$enc_pass = md5($pass);

//validate if email all ready exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);
if ($row) {
    echo "<script>alert('Email already exists!')</script>";
    header('refresh:0;url=http://127.0.0.1/beta/api/src/register_form.html');
    exit();
}
//query to insert data into users table
$query = "insert into users (email, password) 
values('$email', '$enc_pass')";

$result = pg_query($conn, $query);
//execute 
if($result) {
    //echo "Registration susccesful!";
    echo"<script>alert('Registration susccesful!')</script>";
    header('refresh:0;url=http://127.0.0.1/beta/api/src/login_form.html');
} else {
    echo "Registration failed!";
}

pg_close($conn);
?>