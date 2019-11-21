<?php
$allowedTime = 60;
$counter = $allowedTime;
if (isset($_SESSION['nickname'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > $allowedTime) {
        header("location: ../login_register/logout.php");
    } else {
        //use this on every page, so it checks activity
        $_SESSION['last_login_timestamp'] = time();
        echo $counter;
    }
} else {
    echo "<script>alert('You got logged out for being inactive');window.location.href='../login_register/logout.php';</script>";
    header("location: login_register/logout.php");
}