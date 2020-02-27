<?php
session_start();
$title = $_SESSION['title'];

//instructions
echo '<p style="width: 1080px">To close the search input, click the "Histogram" button again!';
echo '<br>The Histogram of '. $title . '</p>';

$dateTimeSeconds = array();
$dateTime = array();
if ($result = mysqli_query($con, $selectSQL)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $dateTime[] = $row['time'];
            $dateTimeSeconds[] = strtotime($row['time']);
        }
    }
}

echo "\n";

//histogram
$dateTimeCount = array_count_values($dateTimeSeconds);

Histogram($dateTimeCount);

function Histogram($array)
{
    $uniqueArray = array();
    $sum = 0;
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("M d H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            echo "<br>" . $dateFormat;
            for($i = 0; $i < $value; $i++){
                echo '*';
                $sum++;
            }
            $uniqueArray[] = $dateFormat;
        }
    }
    echo "<br>SUM: " . $sum;
}

$con->close();

$_SESSION['dateTimeCount'] = $dateTimeCount;
$_SESSION['dateTime'] = $dateTime;