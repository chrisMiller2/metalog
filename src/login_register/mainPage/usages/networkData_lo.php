<?php
$int="lo";
session_start();

$rx[] = @file_get_contents("/sys/class/net/$int/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/$int/statistics/tx_bytes");
sleep(1);
$rx[] = @file_get_contents("/sys/class/net/$int/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/$int/statistics/tx_bytes");

$tbps = $tx[1] - $tx[0];
$rbps = $rx[1] - $rx[0];

$round_rx=round($rbps/1024, 2);
$round_tx=round($tbps/1024, 2);

$time=date("U")."000";
$_SESSION['rx3'][] = "[$time, $round_rx]";
$_SESSION['tx3'][] = "[$time, $round_tx]";
$data['label'] = $int;
$data['data'] = $_SESSION['rx3'];
# to make sure that the graph shows only the
# last minute (saves some bandwitch to)
if (count($_SESSION['rx3'])>60)
{
    $x = min(array_keys($_SESSION['rx3']));
    unset($_SESSION['rx3'][$x]);
}

# json_encode didnt work, if you found a workarround pls write me
# echo json_encode($data, JSON_FORCE_OBJECT);

echo '
    {"label":"'.$int.'","data":['.implode($_SESSION['rx3'], ",").']}
    ';