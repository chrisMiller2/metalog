<?php
//infos about the Server
$servername = "192.168.56.101";
$serverUsername = "christian";
$serverPassword = "christian";
$DBName = "loginData";

$con=mysqli_connect($servername,$serverUsername,$serverPassword,$DBName);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}