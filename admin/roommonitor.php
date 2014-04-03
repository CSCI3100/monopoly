<?php
require '../database.php';
foreach (glob("../class/*.php", GLOB_NOCHECK) as $filename) {
    require "$filename";
}
$room = new Room($db);
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
        <div class="admin_nav_bar_icon">
        <a href="./index.php">
        <i class="fa fa-dashboard"></i><br />Dashboard
        </a>
        </div>
        <div class="admin_nav_bar_icon">
        <a href="./member.php">
        <i class="fa fa-user"></i><br />Member
        </a>
        </div>
        <div class="admin_nav_bar_icon hover">
        <a class="hover" href="./room.php">
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
            <i class="fa fa-user"></i> Room: <?=$room->getroomname($_GET['rid']);?>
            </div>
            <div class="admin_panel_content whiteborder nopadding">
            <div class="admin_panel_player">
            Player 1
            </div>
            <div class="admin_panel_player">
            Player 2
            </div>
            <div class="admin_panel_player">
            Player 3
            </div>
            <div class="admin_panel_player">
            Player 4
            </div>
            </div>
        </div>
    </div>
</div>
</body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
     <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
<script>
var host;
var socket;
$(document).ready(function(){
    SetupWebSocket();
    var myVar=setInterval(function(){sendmonitor()},1000);
});
function sendmonitor(){
    var msg = {};
    msg.act = "monitor";
    msg.rid = "<?=$_GET['rid']?>";
    socket.send(JSON.stringify(msg));
}
function SetupWebSocket(){
        host = 'ws://<?=$_SERVER['SERVER_NAME']?>:9876/mono/server.php';
        socket = new WebSocket(host);
        socket.onopen = function(e) {
        var msg = {};
        msg.act = "monitor";
        msg.rid = "<?=$_GET['rid']?>";
        socket.send(JSON.stringify(msg));
        };
        socket.onmessage = function(e) {
            var retData=$.parseJSON(e.data);
            console.log(retData);
            if(retData['act'] == "updateplayers"){
                var i =0;
                for(i = 0;i < retData['players'].length; i++){
                    $('.admin_panel_player:eq('+i+')').html(retData['players'][i]['name']+'<br /><img src="../data/'+retData['players'][i]['name']+'.png"><br />Money:$'+retData['players'][i]['money']);
                }
            }
        };
        socket.onclose = function(e) {
            alert('Disconnected - status ' + this.readyState);
        };
}
</script>
</html>
