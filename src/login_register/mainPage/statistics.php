<?php
session_start();
$title = $_SESSION['title'];

//instructions
echo '<p style="width: 1080px">To close the search input, click the "Histogram" button again!';
echo '<br>The Histogram of '. $title . '</p>';

//get times
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

function Dates($array)
{
    $uniqueArray = array();
    $sum = 0;
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("M d H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            for($i = 0; $i < $value; $i++){
                $sum++;
            }
            $uniqueArray[] = $dateFormat;
        }
    }
    echo "<br>SUM: " . $sum;
    return $uniqueArray;
}

$con->close();

$split = Split_date($dateTime);

function Split_date($array){
    $splitDate = array();
    foreach ($array as $item){
        $splitDate = date_parse_from_format
        ('M d H:i:s', $item);
    }

    $month[] = $splitDate['month'];
    $day[] = $splitDate['day'];
    $hour[] = $splitDate['hour'];
    $min[] = $splitDate['minute'];
    $sec[] = $splitDate['second'];
}
$dates = Dates($dateTimeCount);
//rearrange the array
$count = array_values($dateTimeCount);
?>
<table>
    <tr>
        <td>
            <canvas id="chartHistogram" width="1800" height="800"></canvas>
            <script src="Chart.js"></script>
            <script>
                let histogram_Time = <?php echo json_encode($dates); ?>;
                let counts = <?php echo json_encode($count); ?>;
                new Chart(document.getElementById("chartHistogram"),
                    {"type":
                            "line",
                        "data":
                            {"labels":
                                histogram_Time
                                ,"datasets":[
                                    {
                                        "label":"Log happened",
                                        "data": counts,
                                        "fill":
                                            false,"borderColor":
                                            "rgb(0, 139, 214)",
                                        "lineTension":
                                            0.25}]},
                        "options":{

                        }});
            </script>
        </td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
</table>