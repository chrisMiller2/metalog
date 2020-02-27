<?php
session_start();
echo '<p style="text-indent: 100px">To close the search input, click the "Search" button again!</p>';
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