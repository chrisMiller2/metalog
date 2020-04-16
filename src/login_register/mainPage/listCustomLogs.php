<?php
session_start();

$dir = '/var/www/faildomain.com/src/login_register/mainPage/logs/';
echo shell_exec("cd ". $dir . "ls -l");
$files = array_diff(scandir($dir), array('.','..',' '));

//list uploaded files
echo '<select name="select2">';
echo '<option value="null"></option>';
foreach($files as $customLog){?>
    <option value="<?php echo strtolower($customLog); ?>">
        <?php echo $customLog;?></option>
    <?php
}

//handle two different calls
if ($_SESSION['customButtons'] == "logcenter")
{
    echo '</select><br>
<input class="button" type="submit" id="searchListButton" name="searchButton" value="Custom Search"/>
<input class="button" type="submit" id="intervalListButton" name="intervalButton" value="Custom Interval"/>
<input class="button" type="submit" name="histogramButton" value="Custom Histogram"/>';
}else if ($_SESSION['customButtons'] == "index"){
    echo '</select><br>
<input class="button" type="submit" name="selectButton" value="Give me custom logs">';
}

//pass the selected file name

