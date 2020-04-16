<?php
session_start();

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

$dateTimeCount = array_count_values($dateTimeSeconds);

function Dates($array)
{
    $uniqueArray = array();
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("F d, Y H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            $uniqueArray[] = $dateFormat;
        }
    }
    return $uniqueArray;
}

function firstDate($array)
{
    $uniqueArray = array();
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("F d, Y H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            $uniqueArray[] = $dateFormat;
        }
    }
    return $uniqueArray[0];
}

function lastDate($array)
{
    $uniqueArray = array();
    foreach ($array as $key => $value) {
        $dateFormat = gmdate("F d, Y H:i:s", $key);
        if (!in_array($dateFormat, $uniqueArray)) {
            $uniqueArray[] = $dateFormat;
        }
    }
    return end($uniqueArray);
}

$firstTime = firstDate($dateTimeCount);
$lastTime = lastDate($dateTimeCount);
$dates = Dates($dateTimeCount);
?>

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    let first_time = <?php echo json_encode($firstTime); ?>;
    let last_time = <?php echo json_encode($lastTime); ?>;
    let times = <?php echo json_encode($dates); ?>;
    let phpFirstTime;
    let phpLastTime;
    $(function() {
        $("#slider-range").slider({
            range: true,
            min: new Date('January 01, 2020 00:0:00').getTime() / 1000,
            max: new Date('August 01, 2020 00:0:00').getTime() / 1000,
            step: 86400,
            values: [ new Date(first_time).getTime() / 1000, new Date(last_time).getTime() / 1000 ],
            slide: function( event, ui ) {
                $("#amount").val((new Date(ui.values[0]*1000).toDateString())+"-"+(new Date(ui.values[1]*1000)).toDateString());
                $("#first").val((new Date(ui.values[0]*1000).toDateString()));
                $("#second").val((new Date(ui.values[1]*1000)).toDateString());
                //sending php
                phpFirstTime = $("#first").val();
                phpLastTime = $("#second").val();

            }
        });
        //standard text
        $("#amount").val((new Date($("#slider-range").slider("values",0)*1000).toDateString()) +
            " - " + (new Date($("#slider-range").slider("values",1)*1000)).toDateString());
    });

    let phpFirstTimeSec;
    let phpLastTimeSec;

    function onPress() {
        //converts time to milliseconds, thus we need to divide to get seconds

        phpFirstTimeSec = ((Date.parse(phpFirstTime)) / 1000);
        phpLastTimeSec = ((Date.parse(phpLastTime)) / 1000);
        console.log(phpFirstTimeSec + " - " + phpLastTimeSec);


        var http = new XMLHttpRequest();
        http.open("GET", "", true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = "first=" + phpFirstTimeSec;
        http.send(params);
        http.onload = function() {
            window.location.href = "intervalData.php?first=" + phpFirstTimeSec + "&sec=" + phpLastTimeSec;
        }
    }
</script>
<form method="get" action="">
    First: <input class="novisibility" name="firstName" for="amount" id="first" />
    Second: <input class="novisibility" name="secondName" for="amount" id="second" />
    <input type="submit" name="submit" value="Filter" id="filterID" onclick="onPress();return false;">
</form>


<br>
<div id="slider-range"></div>
<input type="text" id="amount"/>

<div id="content"></div>

<div id="showData"></div>

<p style="width: 1080px">To close the interval panel, click the "Interval" button again!</p>


<?php
    print_r($_POST);
?>