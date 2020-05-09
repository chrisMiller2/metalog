<?php
session_start();

$timer = $_SESSION['expire_time'] - (time()-$_SESSION['last_activity']);
echo date('i:s', $timer);

if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
    echo "<script>
        alert('You have been logged out due to inactivity!');
        window.location.href='/../logout.php';
</script>";
}