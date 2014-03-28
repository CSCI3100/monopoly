<?php
require '../database.php';
foreach (glob("../class/*.php", GLOB_NOCHECK) as $filename) {
    require "$filename";
}
//$load = sys_getloadavg();
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

$user = new User($db);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Monopoly - Admin Panel</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/admin.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</style>
<script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
<nav class="admin_nav_bar">
    <div class="admin_nav_bar_center">
        <div class="admin_nav_bar_icon hover">
        <a class="hover" href="./index.php">
        <i class="fa fa-dashboard"></i><br />Dashboard
        </a>
        </div>
        <div class="admin_nav_bar_icon">
        <a href="./member.php">
        <i class="fa fa-user"></i><br />Member
        </a>
        </div>
        <div class="admin_nav_bar_icon">
        <a href="./room.php">
        <i class="fa fa-home"></i><br />Room
        </a>
        </div>
    </div>
</nav>
<div class="admin_panel">
    <div class="admin_panel_header">
    Welcome to Admin Panel
    </div>
    <div class="admin_panel_content">
        <div class="admin_panel_round">
            <div class="admin_panel_round_header">
            <i class="fa fa-bar-chart-o"></i> Server Status
            </div>
            <ul>
            <li class="stats">CPU<br /><?=$cpuUsage?>%</li>
            <li class="stats">RAM<br /><?= get_server_memory_usage() ?>%</li>
            <li class="stats">NET<br />50%</li>
            <li class="stats">UPTIME<br /><?=$uptime;?></li>
            </ul>
        </div>
    </div>
</div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</body>
</html>
