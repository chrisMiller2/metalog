<?php
session_start();?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetaLog</title>
    <link rel="stylesheet" href="Main.css">
    <link rel=" shortcut icon" href="../images/favicon.png" type="img/png" />
</head>
<body>
    <div class="menu" id="reload">
        <ul id="menu">
            <li class="menu" id=main><a href="userIndex.php"><h2>MetaLog</h2></a></li>

            <li class="menu"><a href="about.php"><h2>About</h2></a></li>

            <li class="menu"><a href="log-CenterUser.php"><h2>LOG-CENTER</h2></a></li>

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
            </li>
        </ul>
    </div>