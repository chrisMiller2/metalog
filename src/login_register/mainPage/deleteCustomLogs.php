<?php
session_start();

if($_SESSION['userType'] == 'User'){
    require_once('template/headerUserTemplate.php');
}else{
    require_once('template/headerAdminTemplate.php');
}

if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
    header("Location: \..\logout.php");
} else {
    $_SESSION['last_activity'] = time();
}

//infos about the Server
include "../customDbInfo.php";
$getUserTypeSQL = "SELECT * FROM Status";
$result = $con->query($getUserTypeSQL);

$userTypeArray = array();
while($row = $result->fetch_assoc()) {
    $userTypeArray[] = $row['Type'];
}