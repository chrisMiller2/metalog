<?php
session_start();
require_once('Template/headerAdminTemplate.php'); ?>


    <div class="heroImage">
        <div class="heroText">
            Welcome to the LOG-CENTER
            <hr>
            <table>
                <tr>
                    <td>
                        <span style="color: #ffffff"><h2>LOG-SEARCH</h2>
                            <form action="log-CenterAdmin.php" method="post">
                                <!--search-->
                                <form action="" method="post">
                                    <div>
                                        <select name="searchSelect" onchange="customlogList(this);">
                                            <?php include_once "dropDownList.php"?>
                                        </select>
                                    </div>
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
                                        <?php $_SESSION['customButtons'] = "logcenter"; require "listCustomLogs.php" ?>
                                    </div>
                                    <div id="customSelectHiddenButton">
                                        <input class="button" type="submit" id="searchListButton" name="searchButton" value="Search"/>
                                        <input class="button" type="submit" name="histogramButton" value="Histogram"/>
                                    </div>
                                    <?php include "selectLogs.php";?>
                                </form>
                            </form>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php require_once('Template/footerTemplate.php'); ?>