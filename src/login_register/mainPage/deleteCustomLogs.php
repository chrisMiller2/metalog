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
//infos about the Server
include "../customDbInfo.php";

?>
<div class="heroImage">
    <div class="heroText">
        <h1>Select the custom logs you wish to delete for good!</h1>
        <?php
        $selectTablesSQL = mysqli_query($con, "SHOW TABLES");
        ?>
        <table>
            <tr>
                <td>
                    <table>
                        <?php
                        $id = 1;
                        while($table = mysqli_fetch_array($selectTablesSQL))
                        {
                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td><a href='#' style='text-decoration: none; color: #fff'>" . $table[0] . "</a></td>";
                            echo "</tr>";
                            $id++;
                        }
                        ?>
                    </table>
                </td>
                <td>
                    <form action="" method="post">
                        <select name="delLog" style="width: 400px">
                            <?php
                            $selectTablesSQL = mysqli_query($con, "SHOW TABLES");
                            while($table = mysqli_fetch_array($selectTablesSQL))
                                echo "<option value='".$table[0]."'>".$table[0]."</option>";
                            ?>
                        </select>
                        <input type="submit" name='delLogButt' value="Delete"/>
                    </form>
                    <?php
                    $selectTablesSQL = mysqli_query($con, "SHOW TABLES");
                    if (isset($_POST['delLogButt'])) {
                        $tableSelect = $_POST['delLog'];
                        mysqli_query($con, "DROP TABLE IF EXISTS `" . $tableSelect . "`");
                        //refreshes the site
                        echo "<meta http-equiv='refresh' content='0'>";
                    }

                    mysqli_close($con);?>
                </td>
            </tr>
        </table>



    </div>
</div>
<?php
require_once('template/footerTemplate.php');