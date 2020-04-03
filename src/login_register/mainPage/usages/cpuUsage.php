<?php
function get_server_cpu_usage(){
    $load = sys_getloadavg();
    $cpuload = $load[0];
    return $cpuload . " %";
}
echo get_server_cpu_usage();
