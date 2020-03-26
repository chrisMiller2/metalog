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
    $(function() {
        $( "#slider-range" ).slider({
            range: true,
            min: new Date('January 01, 2020 00:0:00').getTime() / 1000,
            max: new Date('August 01, 2020 00:0:00').getTime() / 1000,
            step: 86400,
            values: [ new Date(first_time).getTime() / 1000, new Date(last_time).getTime() / 1000 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( (new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
            }
        });
        $( "#amount" ).val( (new Date($( "#slider-range" ).slider( "values", 0 )*1000).toDateString()) +
            " - " + (new Date($( "#slider-range" ).slider( "values", 1 )*1000)).toDateString());
    });

</script>
<!--Need to react with the searchFunction. Extract the date interval-->
<script>
    function searchFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("searchUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    function searchSliderFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("amount");
        filter = input.value.toUpperCase();
        ul = document.getElementById("searchUL");
        li = ul.getElementsByTagName("li");
        console.log("yes");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>
    <label for="amount">Date range:</label>
    <input type="text" id="amount" onchange="searchSliderFunction()"/>

<div id="slider-range"></div>

<?php
//instructions
echo '<p style="width: 1080px">To close the search input, click the "Search" button again!</p>';

echo "<br><input id='searchInput' onkeyup='searchFunction()' 
type='search' placeholder='Search...' name='search'>";

echo "<ul id='searchUL'>";

if ($statement->num_rows > 0) {
    while ($row = $statement->fetch_assoc()) {
        echo "<li><a href='#'>" . $row["time"]. " : " . $row["service"] . " : " . $row["message"] . "</a></li>";
    }
} else {
    echo "<textarea rows='1' readonly>0 results</textarea>";
}
echo "</ul>";

$con->close();