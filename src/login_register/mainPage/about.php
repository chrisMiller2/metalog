<?php
if(basename($_SERVER['HTTP_REFERER']) == 'log-CenterUser.php')
    require_once('Template/headerUserTemplate.php');
else
    require_once('Template/headerAdminTemplate.php');?>

    <div class="heroImage">
        <div class="heroText">
            This is a university thesis project developed by Krisztián Molnár.

            <h1>How to use</h1>
            On the 'MetaLog' page, choose the log files you wish to read.
            <br>Then click
            the 'Give me logs' button to view the file.
            <br>
            On the page 'LOG-CENTER' you can see the statistics of the read file.
            <br>Also you can search among the rows of the file.
        </div>
    </div>

<?php
require_once('Template/footerTemplate.php');