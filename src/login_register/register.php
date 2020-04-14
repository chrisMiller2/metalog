<?php

//infos about the Server
include "dbInfo.php";

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
    die("Connection failed: " . $con->connect_error . mysqli_error());
}

//insert user data
$insertUserSQL = "INSERT INTO loginData (email, password, isAdmin, nickname) VALUES
        ('$email', '$encrypted', 0, '$nickname')";

$error = array();

//insert into database
if($email == $filteredEmail){
    $error = valid_pass($password, $error);
    if(empty($error)){
        if ($password == $confirmedPassword) {
            mysqli_query($con, $insertUserSQL);
            echo "you have successfully registered as a user!<br>";
            echo "<a href='login.html'>Return to the login page</a>";
        } else {
            echo "<script>alert('The passwords dont match!');window.location.href='register.html';</script>";
        }
    }else{
        echo "<script>alert('".$error['cause']."');window.location.href='register.html';</script>";
    }
}else{
    echo "<script>alert('This is not a valid email!');window.location.href='register.html';</script>";
}

function valid_pass($password, $error) {
    $uppercase='/[A-Z]/';  //Uppercase
    $lowercase='/[a-z]/';  //lowercase
    $special='/[!@#$%^&*()\-_=+{};:,<.>]/';  //special character
    $number='/[0-9]/';  //numbers

    if(preg_match_all($uppercase,$password, $o)<1) {
        $error = array("cause" => "Use at least one uppercase letter");
        return $error;
    }

    if(preg_match_all($lowercase,$password, $o)<1) {
        $error = array("cause" => "Use at least one lowercase letter");
        return $error;
    }

    if(preg_match_all($special,$password, $o)<1) {
        $error = array("cause" => "Use at least one special letter");
        return $error;
    }

    if(preg_match_all($number,$password, $o)<1) {
        $error = array("cause" => "Use at least one number");
        return $error;
    }

    if(strlen($password)<8){
        $error = array("cause" => "The password must be at least 8 characters long");
        return $error;
    }

    return $error;
}

mysqli_close($con);
