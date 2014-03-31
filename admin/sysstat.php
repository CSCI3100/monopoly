<?php

$load = sys_getloadavg();
$cpuUsage = $load[0];
function get_server_memory_usage(){
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;

    return substr($memory_usage,0,2);
}
$data = shell_exec('uptime');
$uptime = explode(' up ', $data);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0];

$a = shell_exec('ifstat -q 3 1 | grep "\." | awk \'BEGIN { FS=" " } { print $1","$2 }\'');
$a = explode(",", $a);
$net = $a[0] + $a[1];

$result = array('load' => $cpuUsage, 'mem' => (int) get_server_memory_usage(), 'uptime' => $uptime, 'net' => ($net/2.0)*100);

echo json_encode($result);

?>