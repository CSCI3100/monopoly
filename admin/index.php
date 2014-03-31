<?php
require '../database.php';
foreach (glob("../class/*.php", GLOB_NOCHECK) as $filename) {
    require "$filename";
}
/*
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
*/

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

<script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
  google.load('visualization', '1', {packages:['gauge']});
  options = {
    width: 200, height: 200,
    redFrom: 90, redTo: 100,
    yellowFrom:75, yellowTo: 90,
    greenFrom:25, greenTo: 75,
    minorTicks: 5,
    min: 0,
    max: 100,
    animation:{
        duration: 1000,
        easing: 'linear',
      }
  };
  google.setOnLoadCallback(drawChart);
 // google.setOnLoadCallback(drawMEMChart);
 // google.setOnLoadCallback(drawNETChart);

  
  
  function drawChart() {
    datac = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['System', 0]
    ]);

    datam = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Memory', 0]
    ]);

    datan = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Network', 0]
    ]);
    cpuC = new google.visualization.Gauge(document.getElementById('cpu'));
    cpuC.draw(datac, options);
    memC = new google.visualization.Gauge(document.getElementById('mem'));
    memC.draw(datam, options);
    netC = new google.visualization.Gauge(document.getElementById('net'));
    netC.draw(datan, options);

  }
  function updateChart(cpu,mem,net) {
    /*
    var datac = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['System', cpu]
    ]);
    

    var datam = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Memory', mem]
    ]);
    

    var datan = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Network', net]
    ]);
*/
    datac.setValue(0, 1, cpu);
    //var cpuC = new google.visualization.Gauge(document.getElementById('cpu'));
    cpuC.draw(datac, options);
    datam.setValue(0, 1, mem);
    //var memC = new google.visualization.Gauge(document.getElementById('mem'));
    memC.draw(datam, options);
    datan.setValue(0, 1, net);
    //var netC = new google.visualization.Gauge(document.getElementById('net'));
    netC.draw(datan, options);

  }
 
</script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/admin.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

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
            <script type="text/javascript">
            function refstat(){
                //alert("HI");
                $.ajax({
                    url: 'sysstat.php',
                    type: 'GET',
                    success: function(response){
                        $data = $.parseJSON(response);
                        $('#system').html($data['load'] + "%");
                        $('#memory').html($data['mem'] + "%");
                        $('#network').html($data['net'] + "%");
                        $('#uptime').html($data['uptime']);
                        updateChart($data['load'],$data['mem'],$data['net']);
                    }
                });
            }
            $(document).ready(function(){
                
                $('#system').html("Updating");
                $('#memory').html("Updating");
                $('#network').html("Updating");
                $('#uptime').html("Updating");
                setInterval(refstat, 1000);
            });
            </script>
            <li class="stats">System<br /><span id="system"></span><br/><div style="padding-left:5px;" id='cpu'></div></li>
            <li class="stats">Memory<br /><span id="memory"></span><br/><div style="padding-left:5px;" id='mem'></div></li>
            <li class="stats">Network<br /><span id="network"></span><br/><div style="padding-left:5px;" id='net'></div></li>
            <li class="stats">Uptime<br /><span id="uptime"></span></li>
            </ul>
        </div>
    </div>
</div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</body>
</html>
