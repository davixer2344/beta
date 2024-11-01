<?php

    function save_data_supabase($email, $passwd){
        //supabase database configuration
        $SUPABASE_URL = 'https://jlytfztdxbjpqnvewffe.supabase.co';
        $SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImpseXRmenRkeGJqcHFudmV3ZmZlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAzODg3MDIsImV4cCI6MjA0NTk2NDcwMn0.d7ULpTS_q69LNXqjTy7Ni_LUbLszS0br9nkfkWStwz4';

        $url = "$SUPABASE_URL/rest/v1/users";
        $data = ['email' => $email, 'password' => $passwd,];

        $options = [
            'http'=> [
                'header' => [
                    "content-type: application/json",
                    "Authorization: Bearer $SUPABASE_KEY",
                    "apikey: $SUPABASE_KEY"
                ],
                'method' => 'POST',
                'content' => json_encode($data)
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, true, $context);
        //$response_data = json_decode($response, true);

        if($response === false){
            echo"Error: Unable to save data to supabase";
            exit;
        }
        echo "User has been created.";// json_encode($response_data);
    }

    //DB CONNECTION 
    require('../../config/db_connection.php');
    //Get data from form submission
    $email=$_POST['email'];
    $pass=$_POST['passwd'];

    //Encrypt password with password
    $enc_pass = md5($pass);
    //validate if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = pg_query($conn, $query);
    $row = pg_fetch_assoc($result);

    if ($row) {
        echo "<script>alert('email already exists!')</script>";
        header('refresh:0;url=http://127.0.0.1/beta/api/src/register_form.html');
        exit();
    }
    //query to insert data into users table
    $query = "INSERT INTO users (email,password)
    VALUES('$email','$enc_pass')";

    //Execute query
    $result = pg_query($conn, $query);

    if ($result){
        //echo "Registration successfully;
        save_data_supabase($email, $enc_pass);
        echo"<script>alert('Registration successful!')</script>";
        header('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
        }else{
        echo"Registration failed!";
    }
    pg_close($conn);
?>
