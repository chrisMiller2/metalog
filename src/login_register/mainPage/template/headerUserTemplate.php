<?php
session_start();?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetaLog</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="icon" href="../images/favicon.png" sizes="16x16" type="image/png" />
    <script type="text/javascript">
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            h = checkTime(h);
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
            t = setTimeout(function() {
                startTime()
            }, 500);
        }
        startTime();
    </script>
</head>
<body onload="startTime()">
<div class="menu" id="reload">
    <ul id="menu">
        <li class="menu" id=main><a href="userIndex.php"><h2>MetaLog</h2></a></li>

        <li class="menu"><a href="about.php"><h2>About</h2></a></li>

        <li class="menu"><a href="log-Center.php"><h2>LOG-CENTER</h2></a></li>

        <li class="menu"><a href="" onclick="window.location.reload()"><img id="refresh" src="https://img.icons8.com/officel/2x/refresh.png" alt="refresh"></a></li>


        <!--nickname-->
        <li class="menu" id="menuRight">
            <div class="dropdown">
                <div class="img-with-text">
                    <!--                    <img src="../images/usericon.jpg" alt="icon">-->
                    <a href=""><h2><?php echo $_SESSION['nickname'];?></h2></a>
                </div>
                <div class="dropdown-content">
                    <a href="changeNickname.php">Change nickname</a>
                    <a href="changePassword.php">Change password</a>
                    <a href="../../logout.php">Logout</a>
                </div>
            </div>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
            <script>
                let timeout = setInterval(
                    function () {
                        $('#activityCheck').load('countDownTimer.php').fadeIn("slow");
                    }, 1000);
            </script>
        <li class="menu" id="menuRight"><a href="#"><h2>Timeout: <div id="activityCheck"></div></h2></a></li>
        </li>
    </ul>
</div>