<?php

//infos about the Server
include "../dbInfo.php";

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//select query
$selectSQL = "SELECT time, service, message FROM Syslog";
$statement = $con->query($selectSQL);

//executing query
echo "<br><input id=\"searchInput\" onkeyup=\"searchFunction()\" type=\"search\" placeholder=\"Search...\"
                                       name=\"search\">";
echo "<ul id=\"searchUL\">";
if ($statement->num_rows > 0) {
    while ($row = $statement->fetch_assoc()) {
            echo "<li><a href='#'>" . $row["time"]. " : " . $row["service"] . " : " . $row["message"] . "</a></li>";
        }
    } else {
        echo "<textarea rows='1' readonly>0 results</textarea>";
    }
echo "</ul>";

$con->close();