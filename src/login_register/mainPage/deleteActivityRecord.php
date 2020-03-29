<?php
$con=mysqli_connect("192.168.56.101","christian","christian","loginData");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_GET['id'];

$deleteSQL = "DELETE FROM Status WHERE id='".$id."'";
mysqli_query($con,$deleteSQL);
mysqli_close($con);

header("Location: adminIndex.php");