<?php
require_once('headerTemplate/headerUserTemplate.php'); ?>


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
                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Year');
                    data.addColumn('number', 'Balance');

                    data.addRows([

                        <?php
                        for ($i = 0; $i < $countArrayLength; $i++) {
                            echo "['" . $values[$i]['year'] . "'," . $values[$i]['newbalance'] . "],";
                        }
                        ?>
                    ]);

                    var options = {
                        title: 'My Savings',
                        curveType: 'function',
                        legend: {position: 'bottom'}
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                    chart.draw(data, options);
                }
                </script>

            <div class="grid-container">
            <div class="grid-100 grid-parent">
                <div id="curve_chart" style="width: 100%; height: auto"></div>
            </div>

            </div>
            </span>
        </div>
    </div>

<?php require_once('headerTemplate/footerTemplate.php'); ?>