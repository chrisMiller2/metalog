<?php
require_once('headerTemplate/headerAdminTemplate.php');?>

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
                                <select name="select">
                                    <option value="" selected disabled hidden>logs</option>
                                    <option value="syslog">syslog</option>
                                    <option value="mysql/error.log">mysql/error.log</option>
                                    <option value="kern.log">kern.log</option>
                                    <option value="auth.log">auth.log</option>
<!--                                    display the last uploaded log name-->
                                    <option value="custon_log">custom log</option>
                                </select>
                            </div>
                            <input type="submit" name="selectButton" value="Give me logs">
                        </form>
                    </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php
require_once('headerTemplate/footerTemplate.php');