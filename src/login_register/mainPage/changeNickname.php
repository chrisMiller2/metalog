<?php
if($_SESSION['userType'] = 'User')
    require_once('Template/headerUserTemplate.php');
else
    require_once('Template/headerAdminTemplate.php');

if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
    header("Location: \..\logout.php");
}
else {
    $_SESSION['last_activity'] = time();
}

require "../dbInfo.php";

$sql = "SELECT nickname FROM loginData";
$result = $con->query($sql);
$currentNick = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($_SESSION['nickname'] == $row['nickname']){
            $currentNick = $row['nickname'];
        }
    }
}
if(isset($_POST['changeNick'])){
    $newNick = $_POST['newNick'];
    $nickname = $_SESSION['nickname'];

    $updateNicknameSQL =
        "UPDATE loginData SET `nickname`= '" . $newNick . "' WHERE `nickname` = '$nickname'";
    mysqli_query($con, $updateNicknameSQL);
    mysqli_close($con);
    $_SESSION['nickname'] = $newNick;
    //refreshes the site
    echo "<meta http-equiv='refresh' content='0'>";
}

$con->close();

?>
<div class="heroImage">
    <div class="heroText">
        <div class="changeNick">
            <form method="post">
                <h2>Current Nickname: <?php echo $currentNick?></h2>
                <h2>New Nickname: <input class="shortInput" name="newNick"></h2>
                <input type="submit" name="changeNick" class="button" value="Change Nickname" style="vertical-align: middle"><br>
            </form>
        </div>
    </div>
</div>
<?php
require_once('Template/footerTemplate.php');