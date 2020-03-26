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
//print_r($dates);
//print_r($count);
?>
<!--chart-->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div id="chart_div"></div>

    <script type="text/javascript">
        let histogram_Time = <?php echo json_encode($dates); ?>;
        let counts = <?php echo json_encode($count); ?>;
        //let splitTime = <?php //echo json_encode(Split_date($dateTime)); ?>//;
        let format_histogram_time = [];

        let y_axes = [];
        // var counts = {};
        // for (var i = 0; i < histogram_Time.length; i++) {
        //     counts[histogram_Time[i]] = 1 + (counts[histogram_Time[i]] || 0);
        // }

        let newArr = [counts];
        let timeData = [];
        let counter = 0;

        y_axes = Object.values(newArr);

        //test to see the actual values of the arrays
        // newArr.forEach(
        //     coord => {console.log(coord)}
        // );
        // histogram_Time.forEach(
        //     coord => {console.log(coord)}
        // );

        histogram_Time.forEach(
            time => {
                let split = time.split(' ');
                let x_axes = {
                    year: 2020,
                    month: new Date(Date.parse(split[0] +" 1, 2020")).getMonth(),
                    day: parseInt(split[1])
                };
                timeData.push([new Date(x_axes.year, x_axes.month, x_axes.day), 1]);
                counter++;
            }
        );
        //let year = new Date().getFullYear();
        //let month = <?php //echo json_encode($month[]); ?>//;
        //let day = <?php //echo json_encode($day[]); ?>//;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Time of Day');
            data.addColumn('number', 'Occurrence');



            data.addRows(timeData);


            var options = {
                title: 'Histogram of the log',
                width: 900,
                height: 500,
                hAxis: {
                    format: 'MM/dd HH:mm:ss',
                    gridlines: {count: 15}
                },
                vAxis: {
                    gridlines: {color: 'none'},
                    minValue: 0
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

    </script>


<?php


//$_SESSION['dateTimeCount'] = $dateTimeCount;
//$_SESSION['dateTime'] = $dateTime;