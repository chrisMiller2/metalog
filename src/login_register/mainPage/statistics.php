<?php

//infos about the Server
include "../dbInfo.php";

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//sql query
$selectSQL = "SELECT time FROM Syslog";

//ERROR it selects one less row than it should
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

//test to see if it selected the dates
//                foreach ($dateTime as $item){
//                    echo strtotime($item) . "\n";
//                }

//check if array counts are correct
//                print_r(CountSameValues($dateTimeSeconds));
echo "\n";
//histogram
$dateTimeCount = CountSameValues($dateTimeSeconds);
Histogram($dateTimeCount);

function CountSameValues($array)
{
    return (array_count_values($array));
}

function Histogram($array)
{
    $uniqueArray = array();
    $mark = '*';
    $sum = 0;
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("M d H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            echo "<br>" . $dateFormat;
            for($i = 0; $i < $value; $i++){
                echo $mark;
                $sum++;
            }
            $uniqueArray[] = $dateFormat;
        }
    }
    echo "<br>SUM: " . $sum;
}


$con->close();

//create array variable
$values = [];

//pushing some variables to the array so we can output something in this example.
array_push($values, array("year" => "2013", "newbalance" => "50"));
array_push($values, array("year" => "2014", "newbalance" => "90"));
array_push($values, array("year" => "2015", "newbalance" => "120"));

//counting the length of the array
$countArrayLength = count($values);

//passing the dates
//$dateTimeSecondsJS = json_encode($dateTimeSeconds);