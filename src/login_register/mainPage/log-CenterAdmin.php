<?php
session_start();
require_once('Template/headerAdminTemplate.php'); ?>


    <div class="heroImage">
        <div class="heroText">
            Welcome to the LOG-CENTER
            <hr>
            <table>
                <tr>
                    <td>
                        <span style="color: #ffffff"><h2>LOG-SEARCH</h2>
                            <form action="log-CenterAdmin.php" method="post">
                                <!--search-->
                                <form action="" method="post">
                                    <div>
                                        <select name="searchSelect" onchange="customlogList(this);">
                                            <?php include_once "dropDownList.php"?>
                                        </select>
                                    </div>
                                    <!--                                custom list-->
                                    <script>
                                        function customlogList(that) {
                                            if (that.value == "custom_log") {
                                                document.getElementById("customSelect").style.display = "block";
                                                document.getElementById("customSelectHiddenButton").style.display = "none";
                                            } else {
                                                document.getElementById("customSelect").style.display = "none";
                                                document.getElementById("customSelectHiddenButton").style.display = "block";
                                            }
                                        }
                                    </script>
                                    <div id="customSelect" style="display: none;">
                                        <?php $_SESSION['customButtons'] = "logcenter"; require "listCustomLogs.php" ?>
                                    </div>
                                    <div id="customSelectHiddenButton">
                                        <input class="button" type="submit" id="searchListButton" name="searchButton" value="Search"/>
                                        <input class="button" type="submit" name="histogramButton" value="Histogram"/>
                                    </div>
                                    <?php include "selectLogs.php";?>


                                </form>
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
                                </script>
                            </form>
                        </span>
                    </td>
                </tr>
            </table>

            <!--            Histogram-->
            <span style="color: #ffffff">
                <table style="color: #ffffff">
                    <tr>
                        <td>
                            <p><h2>Charts</h2></p>
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                    </tr>
                </table>

                <!--                chart-->

<!--               canvasjs_Chart-->
<!--                <script>-->
<!--                window.onload = function() {-->
<!---->
<!--                    var dataPoints = [];-->
<!---->
<!--                    var chart = new CanvasJS.Chart("chartContainer", {-->
<!--                        animationEnabled: true,-->
<!--                        theme: "light2",-->
<!--                        zoomEnabled: true,-->
<!--                        title: {-->
<!--                            text: "Log frequencies"-->
<!--                        },-->
<!--                        axisY: {-->
<!--                            title: "Frequency",-->
<!--                            titleFontSize: 24,-->
<!--                            prefix: "$"-->
<!--                        },-->
<!--                        data: [{-->
<!--                            type: "line",-->
<!--                            yValueFormatString: "$#,##0.00",-->
<!--                            dataPoints: dataPoints-->
<!--                        }]-->
<!--                    });-->
<!---->
<!--                    function addData(data) {-->
<!--                        var dps = data.price_usd;-->
<!--                        for (var i = 0; i < dps.length; i++) {-->
<!--                            dataPoints.push({-->
<!--                                x: new Date(dps[i][0]),-->
<!--                                y: dps[i][1]-->
<!--                            });-->
<!--                        }-->
<!--                        chart.render();-->
<!--                    }-->
<!---->
<!--                    $.getJSON("https://canvasjs.com/data/gallery/php/bitcoin-price.json", addData);-->
<!---->
<!--                }-->
<!--                </script>-->
<!--                <div id="chartContainer" style="height: 370px; width: 100%;"></div>-->
<!--                <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>-->
<!--                <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>-->


<!--                google chart-->

                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                <?php $dateTimeCount= $_SESSION['dateTimeCount'];$dateTime = $_SESSION['dateTime'];?>

                <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart', 'line']});
                google.charts.setOnLoadCallback(drawBasic);

                var dateTime = <?php echo json_encode($dateTime, JSON_PRETTY_PRINT); ?>;

                function timeConverter(UNIX_timestamp) {
                    var a = new Date(UNIX_timestamp * 1000);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var year = a.getFullYear();
                    var month = months[a.getMonth()];
                    var date = a.getDate();
                    var hour = a.getHours();
                    var min = a.getMinutes();
                    var sec = a.getSeconds();
                    var time = month + ' ' + date + ' ' + hour + ':' + min + ':' + sec;
                    return time;
                }

                function drawBasic() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'X');
                    data.addColumn('number', 'Log');

                    var current = null;
                    var cnt = 0;
                    for (var i = 0; i < dateTime.length; i++) {
                        if (dateTime[i] != current) {
                            current = dateTime[i];
                            if (cnt > 0) {
                                var dateFormat = (timeConverter(current));
                                data.addRows([[current, cnt]]);
                            }

                            cnt = 1;
                        } else {
                            cnt++;
                        }
                    }
                    if (cnt > 0) {
                        // document.write(current + ": " + cnt);
                        data.addRows([[current, cnt]]);
                    }

                    // data.addRows([
                    //     [0, 0], [1, 10], [2, 23], [3, 17], [4, 18], [5, 9],
                    //     [6, 11], [7, 27], [8, 33], [9, 40], [10, 32], [11, 35],
                    //     [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
                    //     [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                    //     [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
                    //     [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
                    //     [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                    //     [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
                    //     [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
                    //     [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
                    //     [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
                    //     [66, 70], [67, 72], [68, 75], [69, 80]
                    // ]);

                    var options = {
                        hAxis: {
                            title: 'Date'
                        },
                        vAxis: {
                            title: 'Frequency'
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
                </script>



                <p id="p1"></p>
            <div class="grid-container">
            <div class="grid-100 grid-parent">
                <div id="chart_div" style="width: 100%; height: auto"></div>
            </div>

            </div>
            </span>
        </div>
    </div>

<?php require_once('Template/footerTemplate.php'); ?>