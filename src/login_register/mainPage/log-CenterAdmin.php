<?php
session_start();
require_once('Template/headerAdminTemplate.php'); ?>


    <div class="heroImage">
        <div class="heroText">
            Welcome to the LOG-CENTER<hr>
            <!--                Screenshot-->
            <div id="screenShotDivID">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
                <script>
                    (function(exports) {
                        function urlsToAbsolute(nodeList) {
                            if (!nodeList.length) {
                                return [];
                            }
                            var attrName = 'href';
                            if (nodeList[0].__proto__ === HTMLImageElement.prototype || nodeList[0].__proto__ === HTMLScriptElement.prototype) {
                                attrName = 'src';
                            }
                            nodeList = [].map.call(nodeList, function(el, i) {
                                var attr = el.getAttribute(attrName);
                                if (!attr) {
                                    return;
                                }
                                var absURL = /^(https?|data):/i.test(attr);
                                if (absURL) {
                                    return el;
                                } else {
                                    return el;
                                }
                            });
                            return nodeList;
                        }

                        function screenshotPage() {
                            var wrapper = document.getElementById('screenShotDivID');
                            html2canvas(wrapper, {
                                onrendered: function(canvas) {
                                    canvas.toBlob(function(blob) {
                                        saveAs(blob, 'HelloThere.png');
                                    });
                                }
                            });
                        }

                        function addOnPageLoad_() {
                            window.addEventListener('DOMContentLoaded', function(e) {
                                var scrollX = document.documentElement.dataset.scrollX || 0;
                                var scrollY = document.documentElement.dataset.scrollY || 0;
                                window.scrollTo(scrollX, scrollY);
                            });
                        }

                        function generate() {
                            screenshotPage();
                        }
                        exports.screenshotPage = screenshotPage;
                        exports.generate = generate;
                    })(window);
                </script>

                <table>
                    <tr>
                        <td>
                            <span style="color: #ffffff"><h2>LOG-SEARCH</h2>
                                <p>
                                    <button class="button" onclick="generate()">Take a SHOT</button>
                                </p>
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
    </div>

<?php require_once('Template/footerTemplate.php'); ?>