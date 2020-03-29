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
                                    <!--                dropdown list-->
                                    Important logs to monitor:<br>
                                    <form action="" method="post">
                                        <div>
                                            <select name="select" onchange="customlogList(this);">
                                                <?php include_once "dropDownList.php"?>
                                            </select>
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

                            <!--                            severity level feedback-->
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
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');