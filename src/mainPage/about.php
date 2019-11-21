<?php
if(basename($_SERVER['HTTP_REFERER']) == 'log-CenterUser.php')
    require_once('headerTemplate/headerUserTemplate.php');
else
    require_once('headerTemplate/headerAdminTemplate.php');?>

    <div class="heroImage">
        <div class="heroText">
            This is a university thesis project developed by Krisztián Molnár.
        </div>
    </div>

<?php
require_once('headerTemplate/footerTemplate.php');