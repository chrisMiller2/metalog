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
<!--                            --><?php //include "charts.php" ?>
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