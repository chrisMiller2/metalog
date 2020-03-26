<?php
session_start();

//infos about the Server
include "../dbInfo.php";

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$selectSQL = "SELECT time FROM Syslog";

//get times
$dateTimeSeconds = array();
$dateTime = array();
if ($result = mysqli_query($con, $selectSQL)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $dateTime[] = $row['time'];
            $dateTimeSeconds[] = strtotime($row['time']);
        }
    }
}


foreach($dateTime as $item){
    echo $item . "\n";
}

$con->close();
//
//$_SESSION['dateTimeCount'] = $dateTimeCount;
//$_SESSION['dateTime'] = $dateTime;