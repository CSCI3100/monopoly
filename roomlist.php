<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Monopoly - Room List</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        </style>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/new.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="html5uploader.js"></script>
		<?php
		$toname="";
        $dname="";
		require './database.php';
		require './config.php';
		session_start();
		if(isset($_POST['username']) && !empty($_POST['username'])){
			$user=new User($db);
			$uid=$user->login($_POST['username'], $_POST['password']);
            $uinfo = $user->userinfo($uid);
		}else{
			$uid=0;
		}
		if($uid || isset($_SESSION['uid'])){
			if(!isset($_SESSION['uid'])){
				$_SESSION['uid']=$uid;
				$_SESSION['name']=$_POST['username'];
                $_SESSION['dname']=$uinfo['displayName'];
				$toname = $_SESSION['name'];
                $dname = $_SESSION['dname'];
			}
			$toname = $_SESSION['name'];
            $dname = $_SESSION['dname'];
		?>
    </head>

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
<div id="fb-root"></div>
<div class="three_col">
        <div class="left">
            <div class="left_header">
            Profile
            </div>
            <div class="left_content">
<?php
    $user=new User($db);
	$userinfo=$user->userinfo($_SESSION['uid']);
?>          
            <ul>
                <?php if(file_exists ( "./data/".$toname.".png")) { ?>
                    <li class="avatar">
                        <img id="toavatar" src="./data/<?=$toname;?>.png"><br/><br/>
                        <b><?=$_SESSION['dname'];?></b>
                    </li>
                <?php }else{ ?>
                    <li class="avatar">
                        <img id="toavatar" src="./data/default.png"><br/><br/>
                        <b><?=$_SESSION['dname'];?></b>
                    </li>
                <?php } ?>
                
                <li>Win:<?=$userinfo['money']?></li>
                <li>Lose:<?=$userinfo['money']?></li>
                <li>Money:<?=$userinfo['money']?></li>
                <li><button class="function_button orangebg"><i class="fa fa-envelope"></i> Message</button></li>
                <li><button class="function_button bluebg"><i class="fa fa-credit-card"></i> Shop</button></a></li>
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
                Rooms
            </div>
            <div class="right_content">
                <div class="right_room_list">
                    <div class="right_rooms">
                    </div>
                </div>
            </div>
            <div class="room_option">
        <?php
        $i=0;
        $room = new Room($db);
        if(($room->getroomno())%4!=0){
            $totalroom=floor($room->getroomno()/4)+1;
        }else{
            $totalroom=$room->getroomno()/4;
        }
        for($i=0;$i<$totalroom;$i++){
        ?>
        <button class="pageno" value="<?=($i+1);?>"><?=($i+1);?></button>
        <?php
        }
        ?>
        <button class="no_createroom">Create</button>
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
    <div class="rechargewin">
	<div class="passwordroom_header">
	Recharge
	</div>
	<div class="create_room_content">
<form action='paypal/checkout.php' METHOD='POST'>
<input type="text" name="amount" id="amount" placeholder="The amount to recharge">
<input type="submit" value="Recharge" name="paypal_submit" id="paypal_submit" style="background:#2ecc71;color:#eee;width: 90px;height:30px;padding-top: 5px;padding-bottom: 5px;padding-left: 15px;padding-right: 15px;border-bottom-width: 0px;">
<input class="cancel_button" type="button" value="Cancel" autocomplete="off" style="width: 70px;height:30px;padding-top: 5px;padding-bottom: 5px;padding-left: 15px;padding-right: 15px;border-bottom-width: 0px; 
    background-color: #e74c3c; color: #FFF">
</form>
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
	
    <div class="changeavatar" id="profile">
        <div class="changeavatar_header">
        Change Profile
        </div>
        <form action="#" class="changeprofile">
			<script type="text/javascript">
	    		$(document).ready(function(){
                    $('#changePasswd').hide();
                    $('#changePassword').click(function(){
                        $('#profileEdit').hide();
                        $('#changePasswd').show();
                        $('#function').val('changePasswd');
                        $('#formReset').click();
                        return false;
                    });
                    $('#changeProf').click(function(){
                        $('#changePasswd').hide();
                        $('#profileEdit').show();
                        $('#function').val('updateProfile');
                        $('#formReset').click();
                        return false;
                    });
                    $('#toavatar').click(function(){
                        $('.create_room').hide();
                        $('.passwordroom').hide();
                        $('#profile').show();
                        $('#formReset').click();
                        return false;
                    });
	    			$('#saveProfile').click(function(){
                        var functCode = $('#function').val();
	    				var uid = $("#uid").val();
	    				var displayname = $("#displayName").val();
	    				var phone = $("#phone").val();
	    				var mobilePhone = $("#mobilePhone").val();
	    				var personalDesc = $("#personalDescr").val();
                        var pw = $("#pw").val();
                        var pw1 = $("#pw1").val();
	    				$.ajax({
	    					url: './ajax.php',
	    					type: 'POST',
	    					data: 'function='+functCode+
                                '&uid='+uid+
                                '&displayName='+displayname+
                                '&phone='+phone+
                                '&mobilePhone='+mobilePhone+
                                '&personalDesc='+personalDesc+
                                '&pw1='+pw+
                                '&pw2='+pw1,
	    					async: false,
	    					success: function(response){
	    						switch(response){
	    							case "200":
	    								alert("Saved!");
                                        location.reload();
	    								break;
	    							case "500":
	    								alert("Database error!");
	    								break;
                                    case "401":
                                        alert("Password doesn't match!");
                                        break;
                                    case "404":
                                        alert("Please don't type empty password!");
                                        break;
	    							case "304":
	    								alert("Profile unchanged!");
	    								break;
	    							default:
	    								alert("Unknown operation! " + response);
	    								break;
	    						}
                    			$('.changeavatar').hide();
	    					}
	    				});
                        $('#formReset').click();
                        return false;
	    			});
	    		});
	    	</script>
        	<div id="drop">Drop new avatar here (PNG Format)</div>
        	<input type="hidden" name="uid" id="uid" value="<?= $_SESSION['uid'] ?>"/>
            <input type="hidden" name="function" id="function" value="updateProfile"/>
            <div id="profileEdit">
        	   <input type="text" name="displayname" id="displayName" placeholder="Display Name: <?= $userinfo['displayName'] ?>" /><br/>
        	   <input type="text" name="phone" id="phone" placeholder="Phone: <?= $userinfo['phone'] ?>" /><br/>
        	   <input type="text" name="mobilePhone" id="mobilePhone" placeholder="Mobile: <?= $userinfo['mobilePhone'] ?>" /><br/>
        	   <textarea type="text" name="personalDesc" id="personalDescr" placeholder="Personal Description: <?= $userinfo['personalDesc'] ?>"></textarea><br/>
        	   <button class="password_button" id="changePassword">Change Password</button><br/>
            </div>
            <div id="changePasswd">
               <input type="password" name="password" id="pw" placeholder="New Password" /><br/>
               <input type="password" name="password2" id="pw1" placeholder="Confirm New Password" /><br/>
               <button class="password_button" id="changeProf">Edit Profile</button><br/>
            </div>
            <button class="save_button" id="saveProfile">Save</button> 
        	<button class="cancel_button">Close</button>
            <input type="reset" id="formReset" style="visibility:hidden" />
        </form>
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
			var pwrid;
			var pwsha1;
            $(document).ready(function(){
				$('svg').fadeOut(500);
				$('.bg1').fadeIn(300);
                if($(window).height()>750){
				    $('.left').height($(window).height()-70);
				    $('.middle').height($(window).height()-70);
				    $('.right').height($(window).height()-70);
				    $('.chat_box').height($(window).height()-70-70-38-300-70);
                }
				$( window ).resize(function() {
                    if($(window).height()>750){
				    $('.left').height($(window).height()-70);
				    $('.middle').height($(window).height()-70);
				    $('.right').height($(window).height()-70);
				       $('.chat_box').height($(window).height()-70-70-38-300-70);
                    }
				});
            	
<?php
if(isset($_SESSION['name'])){
?>
        function SetupWebSocket()
        {
            var host = 'ws://<?=$SERVER_ADDR?>:9876/mono/server.php';
            socket = new WebSocket(host);
            socket.onopen = function(e) {
                var msg = {};
                msg.uname = '<?= $_SESSION['name'];?>';
                msg.dname = '<?=$dname;?>';
                msg.act = "getroomlist";
                msg.page = 1;
                socket.send(JSON.stringify(msg));
            };
            socket.onmessage = function(e) {
                var retData=$.parseJSON(e.data);
                console.log(retData);
                if(retData["act"]=="roomlist"){
                    $('.right_room_list').html("");
                    var i;
                    for(i=0;i<retData["roomlist"].length;i++){
                        var temproom=retData["roomlist"][i];
                        console.log(temproom);
                        var keyicon='';
                        if(temproom['password'] != "da39a3ee5e6b4b0d3255bfef95601890afd80709"){
                            keyicon='&nbsp;<i class="fa fa-lock"></i><input type="hidden" value='+temproom['password']+'>';
                        }
                        $('.right_room_list').append('<div class="right_rooms"><h3>'+temproom["name"]+'</h3>Player:'+temproom['playercount']+'/4'+keyicon+'<br /><button class="enter" value='+temproom['rid']+'>Enter</button></div>');
                    }
                    }else if(retData["act"]=="transferroom"){
                        window.location.href = './room.php?rid='+retData["rid"];
                    }else if(retData["act"]=="chatroommsg"){
                        $('.chat_box').append(retData["dname"]+" : "+retData["sendcontent"]+" ["+retData["stime"]+"]<br />");
                    $('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
                }else if(retData["act"]=="userinfo"){
                    $('.middle_content>ul').html("");
                    for(i=0;i<retData["players"].length;i++){
                        var tempUser = retData["players"][i];
                        $('.middle_content>ul').append('<li><div class="online_player"><i class="fa fa-user"></i>&nbsp;'+tempUser["dname"]+'<i class="fa fa-plus addfd"></i></div></li>');
                    }
                }
            };
            socket.onclose = function(e) {
                socket.close();
                alert('Disconnected - status ' + this.readyState);
            };
        }
				SetupWebSocket();
                /*
                $('.avatar>img').click(function(){
                    $('.cancel_button').click();
                    $('.changeavatar').show();

                })*/
				$('#send_content_submit').click(function(){
					if($('#send_content').val()==''){
						//$('#send_content').focus();
					}else{
                    	var msg = {};
						msg.act = "sendmsg";
						msg.rid = 0; //global message
						msg.uname = '<?= $_SESSION['name'];?>';
						msg.dname = '<?=$dname;?>';
						msg.sendcontent=$('#send_content').val();
						socket.send(JSON.stringify(msg));
						$('#send_content').val('');
					}
                    return false;
				});
<?php
}
?>
				$('#send_content').bind('keyup', function(e) {
					if(e.keyCode==13){
						$('#send_content_submit').click();
					}
				});
				$('#rmpassword').bind('keydown', function(e) {
					if(e.keyCode==13){
						$('.passwordbutton').click();
					}
				});
				$('.passwordbutton').click(function(){
					if($('#rmpassword').val() == ''){
						alert('Please enter the password');
					}else{
						if(pwsha1 == CryptoJS.SHA1($('#rmpassword').val())){
							window.location.href = './room.php?rid='+pwrid;
						}else{
							alert('Wrong password');
						}
					}
                    return false;
				});
                $('.create_room_button').click(function(){
                    if($('#roomname').val()==""){
                        alert('Please enter a room name');
                        $('#roomname').focus();
                        return false;
                    }else{
                    	var msg = {};
						msg.act = "createroom";
						msg.roomname = $('#roomname').val();
						msg.password = $('#password').val();
						socket.send(JSON.stringify(msg));
                        return true;
                    }
                });
				$(document).bind('keyup', function(e) {
						if(e.keyCode==27){
							$('.create_room').hide();
						}
				});
                $('.cancel_button').click(function(){
                	$('.create_room').hide();
					$('.passwordroom').hide();
                    $('.changeavatar').hide();
                    return false;
                });
                $('.pageno').click(function(){
                	//alert($(this).val());
                	var msg = {};
					<?php if(isset($_SESSION['name'])){ ?>
                    msg.uname = '<?= $_SESSION['name'];?>';
					msg.dname = '<?=$dname;?>';
					<?php } ?>
                	msg.act="getroomlist";
                	msg.page=$(this).val();
                	socket.send(JSON.stringify(msg));
                    return false;
                });
                $('.no_createroom').click(function(){
                    $('.cancel_button').click();
                	$('.create_room').show();
                    return false;
                });
				$('.function_button.bluebg').click(function(){
					$('.rechargewin').show();
	                $('.cancel_button').click(function(){
	                	$('.rechargewin').hide();
                        return false;
	                });
                    return false;
				});
                $(document.body).on( "click", '.enter', function() {
            $('.cancel_button').click();
				  //alert($(this).val());
				  if($(this).parent().find('input').length){
					pwsha1 = $(this).parent().find('input').val();
					pwrid = $(this).val();
					//alert(pwrid+' '+pwsha1);
					$('.passwordroom').show();
				  }else{
					window.location.href = './room.php?rid='+$(this).val();
				  }
				});
            });
        </script>
		<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>


		<script>

			var dg = new PAYPAL.apps.DGFlow(
			{
				trigger: 'paypal_submit',
				expType: 'instant'
				 //PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
			});

		</script>
    </body>
</html>
