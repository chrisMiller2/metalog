<?php
require_once('Template/headerAdminTemplate.php');?>

    <div class="heroImage">
        <div class="heroText">
            <table>
                <tr>
                    <!--                read log file-->
                    <td valign="top">
                         <span style="color: #ffffff">
                            <textarea readonly cols="100" rows="80"><?php require_once('readlog.php'); ?></textarea>
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
                                Lines read:
                                <?php echo $_SESSION['counter']; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');