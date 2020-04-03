<?php
require_once('Template/headerUserTemplate.php');?>

    <div class="heroImage">
        <div class="heroText">
            <table>
                <tr>
                    <!--                read log file-->
                    <td valign="top">
                         <span style="color: #ffffff">
                            <textarea id="textarea" readonly cols="100" rows="80"><?php require_once('readlog.php'); ?></textarea>
                         </span>
                    </td>
                    <!--                 line-->
                    <td valign="top">
                        <div class="verticalLine"></div>
                    </td>
                    <!--                right panel-->
                    <td valign="top">
                        <div class="floating">
                            <!--                            import log-->
                            <div class="custom-select">
                                <span style="color: #ffffff">

                                    Import files<br>
                                    <form action="importLogFile.php" method="post" enctype="multipart/form-data">
                                        <input class="browse_button" type="file" name="myfile" id="myfile" /><br>
                                        <input class="button" type="submit" value="upload" onclick="load()">
                                        <!--                                    instructions-->
                                        <script type="text/javascript">
                                            function AlertIt() {
                                                var answer = confirm ("supported formats: .txt, .log\n" +
                                                    "The structure of the file must be like this:\n" +
                                                    "\"TIME SERVICE: MESSAGE\"\n" +
                                                    "Example:\n" +
                                                    "Feb 21 06:44:49 debian systemd[1]: Started Daily man-db regeneration.");

                                            }
                                        </script>
                                        <a href="javascript:AlertIt();" id="instructions">Instructions</a>
                                    </form>
                                    <!--                        <script>-->
                                    <!--                            function load() {-->
                                    <!--                                var s = document.getElementById("loader").style;-->
                                    <!--                                s.animationName = 'loadingIcon';-->
                                    <!--                                s.animationDuration = '3s';-->
                                    <!--                            }-->
                                    <!--                        </script>-->
                                    <!--                        <div class="loader" id="loader"></div>-->

                                    <!--                dropdown list-->
                                    Important logs to monitor:<br>
                                    <form action="" method="post">
                                        <div>
                                            <select name="select" onchange="customlogList(this);">
                                                <?php include_once "dropDownList.php"?>
                                            </select>

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
                                                <?php $_SESSION['customButtons'] = "index"; require "listCustomLogs.php" ?>
                                            </div>

                                        </div>
                                        <div id="customSelectHiddenButton">
                                            <input class="button" type="submit" name="selectButton" value="Give me logs">
                                        </div>
                                    </form>
                                </span>
                            </div>
                            <!--                            count log lines-->
                            <div class="counter">
                                File: <?php echo $_SESSION['title']; ?>
                                <br>
                                Lines read:
                                <?php echo $_SESSION['counter']; ?>
                                <br>
                                Today's log count:
                                <?php echo $_SESSION['today_new_logs']; ?>
                            </div>

                            <!--                            get server usage-->
                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
                            <script type="text/javascript">
                                var auto_refresh_cpu = setInterval(
                                    function () {
                                        $('#CPUusageID').load('usages/cpuUsage.php').fadeIn("slow");
                                    }, 1000);
                                var auto_refresh_ram = setInterval(
                                    function () {
                                        $('#RAMusageID').load('usages/ramUsage.php').fadeIn("slow");
                                    }, 1000);
                            </script>
                            <div class="usage">
                                CPU Usage:
                                <div  id="CPUusageID"></div>
                                RAM Usage:
                                <div  id="RAMusageID"></div>
                                Disk Usage:
                                <style type='text/css'>
                                    .progress {
                                        border: 2px solid #008bd6;
                                        height: 32px;
                                        width: 540px;
                                        margin: 30px auto;
                                    }
                                    .progress .prgbar {
                                        background: #008bd6;
                                        width: <?php include "usages/diskUsage.php"; ?>%;
                                        position: relative;
                                        height: 32px;
                                        z-index: 999;
                                    }
                                    .progress .prgtext {
                                        color: #ffffff;
                                        text-align: center;
                                        font-size: 13px;
                                        padding: 9px 0 0;
                                        width: 540px;
                                        position: absolute;
                                        z-index: 1000;
                                    }
                                    .progress .prginfo {
                                        margin: 3px 0;
                                    }
                                </style>
                                <div class='progress'>
                                    <div class='prgtext'><?php echo $dp; ?>% Disk Used</div>
                                    <div class='prgbar'></div>
                                    <div class='prginfo'>
                                        <span style='float: left;'><?php echo "$du of $dt used"; ?></span>
                                        <span style='float: right;'><?php echo "$df of $dt free"; ?></span>
                                        <span style='clear: both;'></span>
                                    </div>
                                </div>
                            </div>

                            <!--                            log severities-->
                            <div class="severity">
                                <span style="color: red">
                                    Error: <?php echo $_SESSION["error"]; ?>
                                </span>
                                <br>
                                <span style="color: darkorange">
                                Warnings: <?php echo $_SESSION['warn']; ?>
                                </span>
                                <br>
                                Debug: <?php echo $_SESSION['debug']; ?>
                                <br>
                                Notice: <?php echo $_SESSION['notice']; ?>
                            </div>
                            <div class="activity">
                                Username: <?php echo $_SESSION['nickname']; ?>
                                <br>
                                IP: <?php $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
                                echo $ip; ?>
                                <br>
                                Host address: <?php echo $_SERVER['SERVER_NAME']; ?>
                                <br>
                                Last activity: <?php
                                $currentTime = date('Y-m-d H:i:s');
                                echo $currentTime ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <h2>Network usage:</h2>
            <script type="text/javascript" src="usages/js/jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="usages/js/jquery.flot.js"></script>

            <script id="source" language="javascript" type="text/javascript">
                $(document).ready(function() {
                    var options = {
                        lines: { show: true },
                        points: { show: true },
                        xaxis: { mode: "time" }
                    };
                    var data = [];
                    var placeholder = $("#networkTraffic");
                    $.plot(placeholder, data, options);
                    var iteration = 0;

                    function fetchData() {
                        ++iteration;
                        function onDataReceived(series) {
                            // we get all the data in one go, if we only got partial
                            // data, we could merge it with what we already got
                            data = [ series ];

                            $.plot($("#networkTraffic"), data, options);
                            fetchData();
                        }

                        $.ajax({
                            url: "usages/networkData_enp0s8.php",
                            method: 'GET',
                            dataType: 'json',
                            success: onDataReceived
                        });
                    }
                    setTimeout(fetchData, 1000);
                });
            </script>
            <script id="source2" language="javascript" type="text/javascript">
                $(document).ready(function() {
                    var options = {
                        lines: { show: true },
                        points: { show: true },
                        xaxis: { mode: "time" }
                    };
                    var data = [];
                    var placeholder = $("#networkTraffic2");
                    $.plot(placeholder, data, options);
                    var iteration = 0;

                    function fetchData() {
                        ++iteration;
                        function onDataReceived(series) {
                            // we get all the data in one go, if we only got partial
                            // data, we could merge it with what we already got
                            data = [ series ];

                            $.plot($("#networkTraffic2"), data, options);
                            fetchData();
                        }

                        $.ajax({
                            url: "usages/networkData_enp0s3.php",
                            method: 'GET',
                            dataType: 'json',
                            success: onDataReceived
                        });
                    }
                    setTimeout(fetchData, 1000);
                });
            </script>
            <script id="source3" language="javascript" type="text/javascript">
                $(document).ready(function() {
                    var options = {
                        lines: { show: true },
                        points: { show: true },
                        xaxis: { mode: "time" }
                    };
                    var data = [];
                    var placeholder = $("#networkTraffic3");
                    $.plot(placeholder, data, options);
                    var iteration = 0;

                    function fetchData() {
                        ++iteration;
                        function onDataReceived(series) {
                            // we get all the data in one go, if we only got partial
                            // data, we could merge it with what we already got
                            data = [ series ];

                            $.plot($("#networkTraffic3"), data, options);
                            fetchData();
                        }

                        $.ajax({
                            url: "usages/networkData_lo.php",
                            method: 'GET',
                            dataType: 'json',
                            success: onDataReceived
                        });
                    }
                    setTimeout(fetchData, 1000);
                });
            </script>
            <div id="networkTraffic" style="width:1000px;height:400px;"></div>
            <div id="networkTraffic2" style="width:1000px;height:400px;"></div>
            <div id="networkTraffic3" style="width:1000px;height:400px;"></div>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');