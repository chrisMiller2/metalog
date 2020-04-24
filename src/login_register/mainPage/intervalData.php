<?php
session_start();

//infos about the Server
include "../dbInfo.php";

//getting values
$firstValue = $_POST['first'];
$secValue = $_POST['sec'] + (24 * 60 * 60); //add a day to it

//getting db data
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
    case $_SESSION['customLog']:
        include "../customDbInfo.php";
        $val = mysqli_query($con, "SELECT time, service, message FROM `".$_SESSION['customLog']."`");
        if($val !== false){
            $selectSQL = "SELECT time, service, message FROM `".$_SESSION['customLog']."`";
            listData($con, $selectSQL, $firstValue, $secValue);
        }else{
            echo "The table is not read";
        }


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
            if (($convertedTimeFromDB >= $firstValue) && ($convertedTimeFromDB <= $secValue)) {
                echo "<li><a href='#'>" . $row["time"] . " : " . $row["service"] . " : " . $row["message"] . "</a></li>";
            }
        }
    } else {
        echo "<textarea rows='1' readonly>0 results</textarea>";
    }
    echo "</ul>";
}


