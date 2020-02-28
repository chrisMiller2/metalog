<?php
session_start();

//infos about the Server
include "../dbInfo.php";

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['select'])) {
    switch ($_POST['select']) {
        case 'syslog':
            $fileName = "syslog";

            //refresh the Syslog table each time it is run
            $dropSyslogTableSQL = "DROP TABLE IF EXISTS Syslog";
            $createSyslogTableSQL = "CREATE TABLE Syslog (time text, service text, message text)";
            mysqli_query($con, $dropSyslogTableSQL);
            mysqli_query($con, $createSyslogTableSQL);

            readLinesFromLog('/var/log/syslog', $con);
            break;
        case "mysql/error.log":
            $fileName = "mysql/error.log";

            //refresh the Mysql/Error.log table each time it is run
            $dropMysqlErrorlogTableSQL = "DROP TABLE IF EXISTS Mysql_Error_log";
            $createMysqlErrorlogTableSQL = "CREATE TABLE Mysql_Error_log (time text, service text, message text)";
            mysqli_query($con, $dropMysqlErrorlogTableSQL);
            mysqli_query($con, $createMysqlErrorlogTableSQL);

            readLinesFromLog('/var/log/mysql/error.log', $con);
            break;
        case "kern.log":
            $fileName = "kern.log";

            //refresh the Kern.log table each time it is run
            $dropKernlogTableSQL = "DROP TABLE IF EXISTS Kern_log";
            $createKernlogTableSQL = "CREATE TABLE Kern_log (time text, service text, message text)";
            mysqli_query($con, $dropKernlogTableSQL);
            mysqli_query($con, $createKernlogTableSQL);

            readLinesFromLog('/var/log/kern.log', $con);
            break;
        case "auth.log":
            $fileName = "auth.log";

            //refresh the Auth.log table each time it is run
            $dropAuthlogTableSQL = "DROP TABLE IF EXISTS Auth_log";
            $createAuthlogTableSQL = "CREATE TABLE Auth_log (time text, service text, session text, message text)";
            mysqli_query($con, $dropAuthlogTableSQL);
            mysqli_query($con, $createAuthlogTableSQL);

            readLinesFromLog('/var/log/auth.log', $con);
            break;
        case "custom_log":
            //for reading in correct order
            if($_POST['select2'] != "null"){
                $_SESSION['customLog'] = $_POST['select2'];
            }

            $customLogFile = $_SESSION['customLog'];

            //refresh the Custom_log table each time it is run
            $dropCustomTableSQL = "DROP TABLE IF EXISTS Custom_log";
            $createCustomTableSQL = "CREATE TABLE Custom_log (time text, service text, message text)";
            mysqli_query($con, $dropCustomTableSQL);
            mysqli_query($con, $createCustomTableSQL);
            readLinesFromLog("/var/www/faildomain.com/src/login_register/mainPage/logs/".$customLogFile, $con);
            break;
    }
}

if (isset($_POST['searchButton'])) {
    switch ($_POST['searchSelect']) {
        case 'syslog':
            $selectSQL = "SELECT time, service, message FROM Syslog";
            $statement = $con->query($selectSQL);
            include 'searchLog.php';
            break;
        case "mysql/error.log":
            $selectSQL = "SELECT time, service, message FROM Mysql_Error_log";
            $statement = $con->query($selectSQL);
            include 'searchLog.php';
            break;
        case "kern.log":
            $selectSQL = "SELECT time, service, message FROM Kern_log";
            $statement = $con->query($selectSQL);
            include 'searchLog.php';
            break;
        case "auth.log":
            $selectSQL = "SELECT time, service, message FROM Auth_log";
            $statement = $con->query($selectSQL);
            include 'searchLog.php';
            break;
        case "custom_log":
            $selectSQL = "SELECT time, service, message FROM Custom_log";
            $statement = $con->query($selectSQL);
            include 'searchLog.php';
            break;
    }
}

if (isset($_POST['histogramButton'])){
    switch ($_POST['searchSelect']) {
        case 'syslog':
            $title = "syslog:<br>";
            $_SESSION['title'] = $title;
            $selectSQL = "SELECT time FROM Syslog";
            include "statistics.php";
            break;
        case "mysql/error.log":
            $title = "mysql/error.log:<br>";
            $_SESSION['title'] = $title;
            $selectSQL = "SELECT time FROM Mysql_Error_log";
            include "statistics.php";
            break;
        case "kern.log":
            $title = "kern.log:<br>";
            $_SESSION['title'] = $title;
            $selectSQL = "SELECT time FROM Kern_log";
            include "statistics.php";
            break;
        case "auth.log":
            $title = "auth.log:<br>";
            $_SESSION['title'] = $title;
            $selectSQL = "SELECT time FROM Auth_log";
            include "statistics.php";
            break;
        case "custom_log":
            $title = $_SESSION['customLog'].":<br>";
            $_SESSION['title'] = $title;
            $selectSQL = "SELECT time FROM Custom_log";
            include "statistics.php";
            break;
    }
}


