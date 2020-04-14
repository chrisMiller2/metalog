<?php
session_unset();
session_destroy();
session_start();

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 60;
if (isset($_SESSION['nickname']) && ($time - $_SESSION['nickname']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['nickname'] = $time;
}

include "dbInfo.php";

//posting the sent infos about the user
$email = $_POST['email'];
$password = $_POST['password'];

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//select query
$selectSQL = "SELECT * FROM loginData where email = '$email'";
$statement = $con->query($selectSQL);

//executing query
if ($statement->num_rows > 0) {
    while ($row = $statement->fetch_assoc()) {
        //checking user validation
        if (isset($email, $password)) {
            //checking if input is empty
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && password_verify($password, $row['password'])) {
                $_SESSION['expire_time'] = 60*5; //expire time in seconds
                //checking user authentication
                if ($row['isAdmin'] == 1) {
                    $currentTime = date('H:i:s');
                    $_SESSION['nickname'] = $row['nickname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['userType'] = 'Admin';
                    $nickname = $_SESSION['nickname'];
                    $type = "Admin";
                    $date = date('Y-m-d');
                    $insertLoginSQL =
                        "INSERT INTO Status(ID, Username, Type, Login, Date) VALUES (DEFAULT, '$nickname', '$type', '$currentTime', '$date')";
                    mysqli_query($con, $insertLoginSQL);
                    header("Location: \mainPage\adminIndex.php");
                    exit;
                } else if ($row['isAdmin'] == 0) {
                    $currentTime = date('H:i:s');
                    $_SESSION['nickname'] = $row['nickname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['userType'] = 'User';
                    $nickname = $_SESSION['nickname'];
                    $type = "User";
                    $date = date('Y-m-d');
                    $insertLoginSQL =
                        "INSERT INTO Status(ID, Username, Type, Login, Date) VALUES (DEFAULT, '$nickname', '$type', '$currentTime', '$date')";
                    mysqli_query($con, $insertLoginSQL);
                    header("Location: \mainPage\userIndex.php");
                    exit;
                }
            }else{
                echo "<script>alert('(inner)Either email or password is incorrect!');window.location.href='login.html';</script>";
            }
        }
        else{
            echo "<script>alert('Either email or password is missing!');window.location.href='login.html';</script>";
        }
    }
} else {
    echo "<script>alert('Either email or password is incorrect!');window.location.href='login.html';</script>";
}


$con->close();
