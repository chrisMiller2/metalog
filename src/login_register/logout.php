<?php
session_start();

$url = "login.html";

include "dbInfo.php";
$currentTime = date('H:i:s');
$nickname = $_SESSION['nickname'];

$updateLogoutSQL =
    "UPDATE Status SET `Logout`= '" . $currentTime . "' WHERE `Username` = '$nickname' ORDER BY ID DESC LIMIT 1";
mysqli_query($con, $updateLogoutSQL);
mysqli_close($con);

header("Location:$url");