<?php
session_start();

$url = "login.html";
if(isset($_GET["session_expired"])) {
    $url .= "?session_expired=" . $_GET["session_expired"];
}

include "dbInfo.php";
$currentTime = date('H:i:s');
$nickname = $_SESSION['nickname'];
$updateLogoutSQL =
    "UPDATE Status SET `Logout`= '" . $currentTime . "' WHERE `Username` = '$nickname'";
mysqli_query($con, $updateLogoutSQL);
mysqli_close($con);

//echo 'You have been inactive, so we logged you
//out because it is fun to see you leave bye';
//echo '<a href="login.html">Return to the login page</a>';
header("Location:$url");