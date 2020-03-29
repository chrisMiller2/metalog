<?php
require_once('Template/headerAdminTemplate.php');

require "../dbInfo.php";

$sql = "SELECT * FROM loginData";
$result = $con->query($sql);
$currentEncryptedPass = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($_SESSION['nickname'] == $row['nickname'] && $_SESSION['email'] == $row['email']){
            $currentEncryptedPass = $row['password'];
        }
    }
}
if(isset($_POST['changePass'])){
    if($_POST['newPa1'] == $_POST['newPa2']){
        $newPassword = $_POST['newPa1'];
        $email = $_SESSION['email'];
        $nickname = $_SESSION['nickname'];

        $newEncryptedPass = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePassSQL =
            "UPDATE loginData SET `password`= '" . $newEncryptedPass . "' WHERE `nickname` = '$nickname' AND `email` = '$email'";
        mysqli_query($con, $updatePassSQL);
        mysqli_close($con);
        //refreshes the site
        echo "<meta http-equiv='refresh' content='0'>";
    }else{
        echo "<script>alert(\"The passwords don't match!\");</script>";
    }

}

$con->close();

?>
    <div class="heroImage">
        <div class="heroText">
            <div class="changeNick">
                <form method="post">
                    <h2>New Password: <input class="shortInput" id="pw" type="password" name="newPa1"></h2>
                    <h2>Confirm Password: <input class="shortInput" id="pw2" type="password" name="newPa2"></h2>
                    <link rel="stylesheet" type="text/css" href="checkbox.css">
                    <label class="password" for="show">Show password
                        <input type="checkbox" onclick="passwordVisibility()" id="show">
                        <script>
                            function passwordVisibility() {
                                var pass = document.getElementById("pw");
                                if(pass.type === "password"){
                                    pass.type = "text";
                                }else{
                                    pass.type = "password";
                                }
                                var passConf = document.getElementById("pw2");
                                if(passConf.type === "password"){
                                    passConf.type = "text";
                                }else{
                                    passConf.type = "password";
                                }
                            }
                        </script>
                        <span class="checkmark"></span>
                    </label>
                    <br><br>
                    <input type="submit" name="changePass" class="button" value="Change Password" style="vertical-align: middle"><br>
                </form>
            </div>
        </div>
    </div>
<?php
require_once('Template/footerTemplate.php');