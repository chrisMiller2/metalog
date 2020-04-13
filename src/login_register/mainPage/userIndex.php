<?php
require_once('Template/headerUserTemplate.php');

$_SESSION['last_activity'] = time();
$_SESSION['expire_time'] = 90; //expire time in seconds
?>

    <div class="heroImage">
        <div class="heroText">
            <table>
                <tr>
                    <!--                read log file-->
                    <td valign="top">
                         <span style="color: #ffffff">
                            <textarea id="textarea" readonly cols="110" rows="40"><?php require_once('readlog.php'); ?></textarea>
                         </span>
                    </td>

                    <!--                 line-->
                    <td valign="top" rowspan="3">
                        <div class="verticalLine"></div>
                    </td>

                    <!--                right panel-->
                    <td valign="top" rowspan="2">
                        <div class="floating">
                            <div id="log_info_wrapper_bottom">
                                <!--                            get server usage-->
                                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
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
                                    <div id="CPUusageID"></div>
                                    RAM Usage:
                                    <div id="RAMusageID"></div>
                                    Disk Usage:
                                    <style type='text/css'>
                                        .progress {
                                            border: 2px solid #008bd6;
                                            height: 32px;
                                            width: 450px;
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
                                            width: 450px;
                                            position: absolute;
                                            z-index: 1000;
                                        }
                                        .progress .prginfo {
                                            margin: 3px 0;
                                            font-size: 13px;
                                        }
                                    </style>
                                    <div class='progress'>
                                        <div class='prgtext'><?php echo $dp; ?>% Used</div>
                                        <div class='prgbar'></div>
                                        <div class='prginfo'>
                                            <span style='float: left;'><?php echo "Used: $du"; ?></span>
                                            <span style='float: right;'><?php echo "Total: $dt"; ?></span>
                                            <span style='clear: both;'></span>
                                            <br>
                                            <span style='float: left;'><?php echo "Free: $df"; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4>Network usage:</h4>
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
                            <div id="networkTraffic" style="width:720px;height:140px;"></div>
                            <div id="networkTraffic2" style="width:720px;height:140px;"></div>
                            <div id="networkTraffic3" style="width:720px;height:140px;"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="log_info_wrapper_bottom">
                            <div class="custom-select">
                                <span style="color: #ffffff">
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
                                <span style="font-weight: bold">
                                    File:
                                </span><?php echo $_SESSION['title']; ?>
                                <br>
                                <span style="font-weight: bold">
                                    Lines read:
                                </span><?php echo $_SESSION['counter']; ?>
                                <br>
                                <span style="font-weight: bold">
                                    Today's log count:
                                </span><?php echo $_SESSION['today_new_logs']; ?>
                            </div>

                            <!--                            log severities-->
                            <div class="severity">
                                <span style="color: red">
                                    <span style="font-weight: bold">
                                        Error:
                                    </span><?php echo $_SESSION["error"]; ?>
                                </span>
                                <br>
                                <span style="color: darkorange">
                                    <span style="font-weight: bold">
                                        Warnings:
                                    </span><?php echo $_SESSION['warn']; ?>
                                </span>
                                <br>
                                <span style="font-weight: bold">
                                    Debug:
                                </span><?php echo $_SESSION['debug']; ?>
                                <br>
                                <span style="font-weight: bold">
                                    Notice:
                                </span><?php echo $_SESSION['notice']; ?>
                            </div>

                            <!--                            infos about the user and server-->
                            <div class="activity">
                                <span style="font-weight: bold">
                                    Username:
                                </span><?php echo $_SESSION['nickname']; ?>
                                <br>
                                <span style="font-weight: bold">
                                    IP:
                                </span><?php $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
                                echo $ip; ?>
                                <br>
                                <span style="font-weight: bold">
                                    Host address:
                                </span><?php echo $_SERVER['SERVER_NAME']; ?>
                                <br>
                                <span style="font-weight: bold">
                                    Last activity:
                                </span><?php
                                $currentTime = date('Y-m-d H:i:s');
                                echo $currentTime ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');