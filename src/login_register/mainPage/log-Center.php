<?php
session_start();

if($_SESSION['userType'] == 'User'){
    require_once('template/headerUserTemplate.php');
}else{
    require_once('template/headerAdminTemplate.php');
}

if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
    header("Location: \..\logout.php");
} else {
    $_SESSION['last_activity'] = time();
}
?>

    <div class="heroImage">
        <div class="heroText">
            Welcome to the LOG-CENTER
            <hr>
            <!--                Screenshot-->
            <div id="screenShotDivID">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
                <script>
                    (function (exports) {
                        function urlsToAbsolute(nodeList) {
                            if (!nodeList.length) {
                                return [];
                            }
                            var attrName = 'href';
                            if (nodeList[0].__proto__ === HTMLImageElement.prototype || nodeList[0].__proto__ === HTMLScriptElement.prototype) {
                                attrName = 'src';
                            }
                            nodeList = [].map.call(nodeList, function (el, i) {
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
                            let imageName = document.getElementById("imageNameID").value;
                            let imageExt = document.getElementById("imageExtID").value;
                            let wrapper = document.getElementById('screenShotDivID');
                            html2canvas(wrapper, {
                                onrendered: function (canvas) {
                                    canvas.toBlob(function (blob) {
                                        saveAs(blob, imageName+'.'+imageExt);
                                    });
                                }
                            });
                        }

                        function addOnPageLoad_() {
                            window.addEventListener('DOMContentLoaded', function (e) {
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

                <span style="color: #ffffff">
            <table class="logCenterTable">
<!--                title-->
                <tr>
                    <th colspan="3">
                        <?php
                        if(isset($_POST['searchButton']))
                            echo "<h1><hr style='display:inline-block' width='25%'>LOG-SEARCH<hr style='display:inline-block' width='25%'></h1>";
                        elseif(isset($_POST['intervalButton']))
                            echo "<h1><hr style='display:inline-block' width='25%'>LOG-INTERVAL<hr style='display:inline-block' width='25%'></h1>";
                        elseif(isset($_POST['histogramButton']))
                            echo "<h1><hr style='display:inline-block' width='25%'>LOG-HISTOGRAM<hr style='display:inline-block' width='25%'></h1>";
                        else
                            echo "<h1><hr style='display:inline-block' width='25%'>LOG-CENTER<hr style='display:inline-block' width='25%'></h1>";
                        ?>
                    </th>
                </tr>
<!--                screenshot-->
                <tr>
                    <td colspan="3" align="center">
                        <form method="post">
                            <input placeholder="Image name" name="imageName" id="imageNameID" />
                            <input placeholder="Image extension" size="13" name="imageExt" id="imageExtID" />
                        </form>
                        <button class="button" id="imageButton" onclick="generate()">Take a SHOT</button>
                        <hr>
                    </td>
                </tr>
<!--                functions-->
                <tr>
                    <td colspan="3" align="center">
                        <form action="log-Center.php" method="post">
                            <form action="" method="post">
                                <select name="searchSelect" onchange="customlogList(this);">
                                    <?php include_once "dropDownList.php" ?>
                                </select>
                                <!--                                    custom list-->
                                <div id="customSelect" style="display: none;">
                                    <?php $_SESSION['customButtons'] = "logcenter";
                                    require "listCustomLogs.php" ?>
                                </div>
                                <!--                                    buttons-->
                                <div id="customSelectHiddenButton">
                                    <input class="button" type="submit" id="searchListButton" name="searchButton"
                                           value="Search"/>
                                    <input class="button" type="submit" id="intervalListButton" name="intervalButton"
                                           value="Interval"/>
                                    <input class="button" type="submit" name="histogramButton" value="Histogram"/>
                                </div>
                                <?php include "selectLogs.php"; ?>
                            </form>
                        </form>
                    </td>
                </tr>
            </table>
            </span>
            </div>
        </div>
    </div>

<?php require_once('template/footerTemplate.php'); ?>