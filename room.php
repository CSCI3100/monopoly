<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Monopoly - Waiting Room</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        </style>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/new.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="html5uploader.js"></script>
    </head>
<?php
$toname="";
require './database.php';
require './config.php';
session_start();
$dname = $_SESSION['dname'];
$room = new Room($db);
if(isset($_POST['username']) && !empty($_POST['username'])){
	$user=new User($db);
	$uid=$user->login($_POST['username'], $_POST['password']);
}else{
	$uid=0;
}
if($uid || isset($_SESSION['uid'])){
    $toname = $_SESSION['name'];
	if(!isset($_SESSION['uid'])){
		$_SESSION['uid']=$uid;
		$_SESSION['name']=$_POST['username'];
		$toname = $_SESSION['name'];
	}
?>
<body onload="new uploader('drop', 'status', 'uploader.php', 'list', '<?php echo $toname;?>');">
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
				<path id="loading-12-icon" d="M291,82.219c0,16.568-13.432,30-30,30s-30-13.432-30-30s13.432-30,30-30S291,65.65,291,82.219z
					 M261,404.781c-15.188,0-27.5,12.312-27.5,27.5s12.312,27.5,27.5,27.5s27.5-12.312,27.5-27.5S276.188,404.781,261,404.781z
					 M361.504,113.167c-4.142,7.173-13.314,9.631-20.487,5.489c-7.173-4.141-9.631-13.313-5.49-20.487
					c4.142-7.173,13.314-9.631,20.488-5.489C363.188,96.821,365.645,105.994,361.504,113.167z M188.484,382.851
					c-14.348-8.284-32.697-3.368-40.98,10.98c-8.285,14.349-3.367,32.696,10.98,40.981c14.35,8.283,32.697,3.367,40.98-10.981
					C207.75,409.482,202.834,391.135,188.484,382.851z M421.33,184.888c-8.368,4.831-19.07,1.965-23.901-6.404
					c-4.832-8.368-1.965-19.07,6.404-23.902c8.368-4.831,19.069-1.964,23.9,6.405C432.566,169.354,429.699,180.056,421.33,184.888z
					 M135.399,329.767c-8.285-14.35-26.633-19.266-40.982-10.982c-14.348,8.285-19.264,26.633-10.979,40.982
					c8.284,14.348,26.632,19.264,40.981,10.98C138.767,362.462,143.683,344.114,135.399,329.767z M436.031,277.249
					c-11.044,0-20-8.953-20-19.999c0-11.045,8.955-20.001,20.001-20.001c11.044,0,19.999,8.955,19.999,20.002
					C456.031,268.295,447.078,277.249,436.031,277.249z M115.97,257.251c-0.001-16.57-13.433-30.001-30.001-30.002
					c-16.568,0.001-29.999,13.432-30,30.002c0.001,16.566,13.433,29.998,30.001,30C102.538,287.249,115.969,273.817,115.97,257.251z
					 M401.333,364.248c-10.759-6.212-14.446-19.97-8.234-30.73c6.212-10.759,19.971-14.446,30.731-8.233
					c10.759,6.211,14.445,19.971,8.232,30.73C425.852,366.774,412.094,370.46,401.333,364.248z M135.398,184.736
					c8.285-14.352,3.368-32.698-10.98-40.983c-14.349-8.283-32.695-3.367-40.981,10.982c-8.282,14.348-3.366,32.696,10.981,40.981
					C108.768,204,127.115,199.082,135.398,184.736z M326.869,421.328c-6.902-11.953-2.807-27.242,9.148-34.145
					s27.243-2.806,34.146,9.149c6.902,11.954,2.806,27.243-9.15,34.145C349.059,437.381,333.771,433.284,326.869,421.328z
					 M188.482,131.649c14.352-8.286,19.266-26.633,10.982-40.982c-8.285-14.348-26.631-19.264-40.982-10.98
					c-14.346,8.285-19.264,26.633-10.98,40.982C155.787,135.017,174.137,139.932,188.482,131.649z"/>
			</svg>
<div class="three_col">
        <div class="left">
            <div class="left_header">
            <?=$_SESSION['name'];?>
            </div>
            <div class="left_content">
<?php
    $user=new User($db);
	$userinfo=$user->userinfo($_SESSION['uid']);
?>
            <ul>
                <li class="avatar"><img id="toavatar" src="./data/<?=$toname;?>.png"></li>
                <li>Win:<?=$userinfo['money']?></li>
                <li>Lose:<?=$userinfo['money']?></li>
                <li>Money:<?=$userinfo['money']?></li>
                <li><button class="function_button orangebg"><i class="fa fa-envelope"></i> Message</button></li>
                <li><button class="function_button bluebg"><i class="fa fa-credit-card"></i> Shop</button></li>
                <li><a href="./index.php"><button class="function_button greenbg"><i class="fa fa-sign-out"></i> Logout</button></a></li>
            </ul>
            </div>
        </div>
        <div class="middle">
        <div class="middle_header">
        Players
        </div>
        <div class="middle_content">
        <ul>
        <!--playerlist-->
        </ul>
        </div>
        </div>
        <div class="right">
            <div class="right_header">
                Room: <?php echo $room->getroomname($_GET['rid']);?>
            </div>
            <div class="right_content h_fixed">
                <div class="right_room_list">
                </div>
            </div>

            <div class="chat_header">
                Chat
            </div>
            <div class="chat_box">
            </div>
              <div class="chat_send">
               <input type="text" id="send_content">
              <input class="sendsubmit" value="Send" type="submit" id="send_content_submit">
              </div>
        </div>
</div>
    <div class="create_room">
    	<div class="create_room_header">
    	Create a room
    	</div>
    	<div class="create_room_content">
    	<input type="text" id="roomname" name="roomname" placeholder="Name of room">
    	<input type="password" id="password" name="password" placeholder="Password(If any)">
    	<button class="create_room_button">Create</button>
    	<button class="cancel_button">Cancel</button>
    	</div>
    </div>
    <div class="passwordroom">
    	<div class="passwordroom_header">
    	Enter password
    	</div>
    	<div class="create_room_content">
    	<input type="password" id="rmpassword" name="rmpassword" placeholder="Room password">
    	<button class="passwordbutton">Enter</button>
		<button class="cancel_button">Cancel</button>
    	</div>
    </div>
    <div class="changeavatar">
        <div class="changeavatar_header">
        Change avatar
        </div>
        <div id="drop">Drag and drop the image(JPG) here</div>
        <button class="cancel_button">Close</button>
    </div>
    </div> <!-- /container -->
<?php
}else{
$msg="Incorrect password";
?>
    <div class="bg1">
    <div class="login_form bmsg">
    <div class="login_header">
        Error
    </div>
    <h2 class="msg"><?=$msg;?></h2>
	 <a href="./index.php"><button class="warningbutton">Home</button></a>
    </div>
    </div>
    </div> <!-- /container -->
<?php
}
?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	 <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <script>
        var toRid;
        $(document).ready(function(){
        $('svg').fadeOut(500);
        $('.bg1').fadeIn(300);
        SetupWebSocket();
        <?php
        if(isset($_SESSION['name'])){
        ?>
        $('#send_content_submit').click(function(){
        if($('#send_content').val()==''){
        alert('Your message is empty!');
            $('#send_content').focus();
        }else{
        var msg = {};
        msg.act = "sendmsg";
        msg.rid = <?=$_GET['rid'];?>; //global message
                                        msg.uname = '<?= $_SESSION['name'];?>';
        msg.sendcontent=$('#send_content').val();
        socket.send(JSON.stringify(msg));
        $('#send_content').val('');
        }
        });
        <?php
        }
        ?>
        $('#send_content').bind('keydown', function(e) {
        if(e.keyCode==13){
            $('#send_content_submit').click();
        }
        });

        $(document.body).on( "click", '.addfd', function() {
            var msg = {};
            msg.act = "invite";
            msg.uid = $(this).attr('attr');
            msg.rid = <?=$_GET['rid'];?>;
            socket.send(JSON.stringify(msg));
            //alert($(this).attr('attr'));
        });
        $(document.body).on( "click", '.ready', function() {
        var msg = {};
        msg.act = "getready";
        msg.uid = <?=$_SESSION['uid'];?>;
        msg.rid = <?=$_GET['rid'];?>;
        //console.log(msg);
        socket.send(JSON.stringify(msg));
        });
        $(window).on('beforeunload', function(){
        var msg = {};
        msg.act="leaveroom";
        msg.uname = '<?= $_SESSION['name'];?>';
        msg.rid = <?=$_GET['rid'];?>;
        socket.send(JSON.stringify(msg));
        });
        $(document).on("keydown", disableF5);
        });
        function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
        function SetupWebSocket()
        {
            var host = 'ws://<?=$SERVER_ADDR?>:9876/mono/server.php';
            socket = new WebSocket(host);
        socket.onopen = function(e) {
        var msg = {};
        msg.act = "enterroom";
        msg.uname = '<?= $_SESSION['name'];?>';
        msg.dname = '<?= $_SESSION['dname'];?>';
        msg.rid = <?=$_GET['rid'];?>;
        socket.send(JSON.stringify(msg));
        };
        socket.onmessage = function(e) {
            var retData=$.parseJSON(e.data);
        //console.log(retData["roomlist"].length);
        if(retData['act']=='roomplayer'){
            $('.right_room_list').html('');
            var i=0;
            for(i=0;i<retData['players'].length;i++){
            var playerinfo = retData['players'][i];
            console.log(playerinfo);
            if(playerinfo['state']==0){
            var pstate="Not ready";
                if(playerinfo['name']=='<?= $_SESSION['name'];?>'){
                    var readybutton='<br /><button class="ready">Ready</button>';
                }else{
                    var readybutton='';
                }
            }else{
                 var pstate="Ready";
                 var readybutton="";
            }
                $('.right_room_list').append('<div class="right_rooms hf_fixed"><img src="./data/'+playerinfo['name']+'.png"><h4>'+playerinfo['name']+'</h4>State:'+pstate+readybutton+'</div>')
            }
            //console.log(retData);
            if(retData['totalnum'] == 4){
                window.location.href = './play.php?rid='+playerinfo["rid"];
            }
        }else if(retData["act"]=="chatroommsg"){
            $('.chat_box').append(retData["uname"]+" : "+retData["sendcontent"]+" ["+retData["stime"]+"]<br />");
            $('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
        }else if(retData["act"] == "userinfo"){
                $('.middle_content>ul').html("");
                for(i=0;i<retData["players"].length;i++){
                var tempUser = retData["players"][i];
                $('.middle_content>ul').append('<li><div class="online_player"><i class="fa fa-user"></i>&nbsp;'+tempUser["dname"]+'<i attr="'+tempUser["name"]+'" class="fa fa-plus addfd"></i></div></li>');
           }
        }else if(retData["act"] == "invite"){
            console.log(retData);
            //alert('hi');
            toRid = retData['rid'];
            $('.beinvited').show();
        }
        console.log(retData);
        };
            socket.onclose = function(e) {
                alert('Disconnected - status ' + this.readyState);
            };
        }

        </script>
		</body>
</html>
