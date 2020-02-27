<?php
session_start();

//infos about the Server
include "../dbInfo.php";

//connection
$con = new mysqli($servername, $serverUsername, $serverPassword, $DBName);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}?>

<form action="" method="post">
        <div>
            <select name="histogramSelect">
<?php include "dropDownList.php";?>

</select></div>
<input class="button" type="submit" name="selectButton" value="Histogram"></form>

<?php
//load selected option
include_once("selectLogs.php");

// I WANT THIS SHIT OPTIONAL
$selectSQL = "SELECT time FROM Syslog";

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