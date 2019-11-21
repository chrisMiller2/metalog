<?php
require_once('headerTemplate/headerAdminTemplate.php'); ?>


    <div class="heroImage">
        <div class="heroText">
            Welcome to the LOG-CENTER
            <hr>
            <table>
                <tr>
                    <td>
                        <span style="color: #ffffff"><h2>LOG-SEARCH</h2>
                            <form action="log-CenterUser.php" method="get">
                                <!--search-->
                                <label class="switch">
                                    <input type="checkbox" name="listcheck" value="List logs">
                                    <span class="slider"></span>
                                </label>
                                <input type="submit" id="searchListButton" name="listbutton" value="Toggle"/>
                                <?php
                                if ($_GET) {
                                    if (isset($_GET['listcheck']) && isset($_GET['listbutton'])) {
                                        require_once('searchLog.php');
                                    }
                                }
                                ?>
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
                    <tr><td><h2>Histogram</h2></td></tr>
                    <tr>
                        <td>
                            <!--                statistics-->
                            <?php include_once('statistics.php'); ?>
                        </td>
                    </tr>
                </table>

                <!--                chart-->
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart', 'line']});
                google.charts.setOnLoadCallback(drawBasic);

                var array = <?php echo $dateTimeSecondsJS; ?>;
                var count = <?php echo $countJS; ?>
                function drawBasic() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'X');
                    data.addColumn('number', 'Time');
                    for(var key in array){
                        if(array.hasOwnProperty(key)){
                            data.addRows([array[key], key]);
                        }
                    }
                    // data.addRows([
                    //     [0, 0],   [1, 10],  [2, 23],  [3, 17],  [4, 18],  [5, 9],
                    //     [6, 11],  [7, 27],  [8, 33],  [9, 40],  [10, 32], [11, 35],
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
                            title: 'Time'
                        },
                        vAxis: {
                            title: 'Popularity'
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
                </script>

            <div class="grid-container">
            <div class="grid-100 grid-parent">
                <div id="chart_div" style="width: 100%; height: auto"></div>
            </div>

            </div>
            </span>
        </div>
    </div>

<?php require_once('headerTemplate/footerTemplate.php'); ?>