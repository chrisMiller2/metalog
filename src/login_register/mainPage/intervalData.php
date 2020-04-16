<?php
session_start();

//infos about the Server
include "../dbInfo.php";

$firstValue = $_POST['first'];
$secValue = $_POST['sec'] + (24 * 60 * 60); //add a day to it

echo $firstValue . "-" . $secValue . "\n";


switch ($_SESSION['intervalDB']) {
    case 'syslog':
        $selectSQL = "SELECT time, service, message FROM Syslog";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case 'mysql/error.log':
        $selectSQL = "SELECT time, service, message FROM Mysql_Error_log";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case "kern.log":
        $selectSQL = "SELECT time, service, message FROM Kern_log";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case "auth.log":
        $selectSQL = "SELECT time, service, message FROM Auth_log";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case 'ufw.log':
        $selectSQL = "SELECT time, service, message FROM Ufw_log";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case 'messages':
        $selectSQL = "SELECT time, service, message FROM Messages";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
    case "custom_log":
        $selectSQL = "SELECT time, service, message FROM Custom_log";
        listData($con, $selectSQL, $firstValue, $secValue);
        break;
}
$con->close();

function listData($con, $selectSQL, $firstValue, $secValue)
{
    $statement = $con->query($selectSQL);
    echo "<ul id='searchUL'>";

    if ($statement->num_rows > 0) {

        while ($row = $statement->fetch_assoc()) {
            $convertedTimeFromDB = strtotime($row["time"]);
            //FROM works but TO doesnt
            if (($convertedTimeFromDB >= $firstValue) && ($convertedTimeFromDB <= $secValue)) {
                echo "<li><a href='#'>" . $row["time"] . " : " . $row["service"] . " : " . $row["message"] . "</a></li>";
            }
        }
    } else {
        echo "<textarea rows='1' readonly>0 results</textarea>";
    }
    echo "</ul>";
}


