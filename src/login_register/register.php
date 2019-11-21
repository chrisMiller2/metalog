<?php

//infos about the Server
$servername = "192.168.56.10";
$serverUsername = "root";
$serverPassword = "fuckoff";
$DBName = "loginData";


//posting the sent infos about the user
$email = $_POST['email'];
$password = $_POST['password'];
$confirmedPassword = $_POST['confirmedpassword'];
$nickname = $_POST['nickname'];
$encrypted = password_hash($password, PASSWORD_DEFAULT);
$filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed" . $con->connect_error);
}

//insert user data
$insertUserSQL = "INSERT INTO loginData (email, password, isAdmin, nickname) VALUES
        ('$email', '$encrypted', 0, '$nickname')";

//insert into database
if($email == $filteredEmail){
    if ($password == $confirmedPassword) {
        mysqli_query($con, $insertUserSQL);
        echo "you have successfully registered as a user!<br>";
        echo "<a href='login.html'>Return to the login page</a>";
    } else {
        echo "<script>alert('The passwords dont match!');window.location.href='register.html';</script>";
    }
}else{
    echo "<script>alert('This is not a valid email!');window.location.href='register.html';</script>";
}

mysqli_close($con);
