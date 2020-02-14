<?php
require_once('Template/headerAdminTemplate.php');?>

    <div class="heroImage">
        <div class="heroText">
            <table>
                <tr>
                    <!--                read log file-->
                    <td valign="top">
                         <span style="color: #ffffff">
                            <textarea readonly cols="100" rows="50"><?php require_once('readlog.php'); ?></textarea>
                         </span>
                    </td>
                    <!--                 line-->
                    <td valign="top">
                        <div class="verticalLine"></div>
                    </td> 
                    <td valign="top">
                    <span style="color: #ffffff">
                        <!--                import file-->
                        Import files (supported formats: .txt, .log)<br>
                        <form action="importLogFile.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="myfile" id="myfile" /><br>
                            <input type="submit" value="upload" onclick="load()">
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
                        These logs are stored within: /var/log/<br>
                        <form action="" method="post">
                            <div class="custom-select">
                                <select name="select" onchange="customlogList(this);">
                                    <option value="" selected disabled hidden>logs</option>
                                    <option value="syslog">syslog</option>
                                    <option value="mysql/error.log">mysql/error.log</option>
                                    <option value="kern.log">kern.log</option>
                                    <option value="auth.log">auth.log</option>
                                    <option value="custom_log">custom log</option>
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
                                    <?php require_once("listCustomLogs.php")?>
                                </div>
                            </div>
                            <div id="customSelectHiddenButton">
                                <input type="submit" name="selectButton" value="Give me logs">
                            </div>
                        </form>
                    </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');