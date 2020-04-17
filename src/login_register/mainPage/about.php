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
            This is a university thesis project developed by Krisztián Molnár.
            MetaLog uses Ubuntu and custom set log files to be analysed.
            <h1>How to use</h1>
            <p>
                On the 'MetaLog' page, choose the log files you wish to read.
                <br>Then click
                the 'Give me logs' button to view the file.
                <br>
                On the page 'LOG-CENTER' you can see the statistics of the read file.
                <br>Also you can search among the rows of the file.
            </p>
            <table border="1px">
                <th colspan="2">List of build in log files:</th>
                <tr>
                    <td>syslog</td>
                    <td>System level log entries</td>
                </tr>
                <tr>
                    <td>mysql/error.log:</td>
                    <td>MySQL faulty or error log entries</td>
                </tr>
                <tr>
                    <td>kern.log</td>
                    <td>Kernel level log entries</td>
                </tr>
                <tr>
                    <td>auth.log</td>
                    <td>Authentication log entries</td>
                </tr>
                <tr>
                    <td>ufw.log</td>
                    <td>Ubuntu Fire Wall log entries</td>
                </tr>
                <tr>
                    <td>messages</td>
                    <td>Networking log entries</td>
                </tr>
                <tr>
                    <td>custom log</td>
                    <td>Uploaded custom log entries that are not from Ubuntu</td>
                </tr>
            </table>
            <br>
            <p>
                <span class="documentation">
                    <a href="documentation/szakdolgozat.docx">Documentation</a>
                </span>
            </p>
        </div>
    </div>

<?php
require_once('template/footerTemplate.php');