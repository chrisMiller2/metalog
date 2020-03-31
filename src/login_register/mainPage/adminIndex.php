<?php
require_once('Template/headerAdminTemplate.php');?>

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
            <h2>Activity checker</h2>
            <?php
            //infos about the Server
            include "../dbInfo.php";
            $result = mysqli_query($con,"SELECT * FROM Status");
            echo '<form method="post">';
            echo '<input type="submit" name="deleteRows" class="button" value="Delete all activity" style="vertical-align: middle"><br>';
            echo '</form>';
            if(isset($_POST['deleteRows'])){
                $dropStatusTableSQL =
                    "DELETE FROM Status WHERE ID IS NOT NULL";
                mysqli_query($con, $dropStatusTableSQL);
                mysqli_close($con);
                //refreshes the site
                echo "<meta http-equiv='refresh' content='0'>";
            }
            echo "<table border='1' id='activityTable'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Login</th>
                    <th>Logout</th>
                    <th>Date</th>
                    <th>DELETE</th>
                </tr>";

                while($row = mysqli_fetch_array($result))
                {
                echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $row['Type'] . "</td>";
                    echo "<td>" . $row['Login'] . "</td>";
                    echo "<td>" . $row['Logout'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "<td><a href=\"deleteActivityRecord.php?id=".$row['ID']."\">DELETE</a></td>";
                echo "</tr>";
                }
                echo "</table>";

                mysqli_close($con);
            ?>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');