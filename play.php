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

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
<?php
$toname = "";
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
                <li class="avatar"><img id="toavatar" src="./data/<?=$toname;?>.png"><br/><br/>
                       <b><?=$_SESSION['dname'];?></b></li>
                <li>You are in:<b id="p_stop"></b></li>
                <li>Money:<b id="p_money"><?=$settings['start_money']?></b></li>
						<li><button id="dicebutton" onclick="pDice()" class="function_button orangebg"><i class="fa fa-envelope"></i> Dice</button></li>
                <li><button onclick="cDice()" class="function_button orangebg"><i class="fa fa-envelope"></i> Dice</button></li>
                <li><button onclick="checkProp()" class="function_button bluebg"><i class="fa fa-credit-card"></i> Property</button></li>
                <li>You still have <b id="show-time"><?=$settings["round_time"];?></b> seconds<br /><button onclick="finishRound()" id="finishbutton" class="function_button greenbg"><i class="fa fa-sign-out"></i> Finish this round</button></li>
            </ul>
            </div>
        </div>
        <div class="middle">
        <div class="middle_header">
        Players
        </div>
        <div class="room_players_other">
        <div class="room_players_other_indiv">
				<svg class="miniload" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
			</div>
			<div class="room_players_other_indiv">
				<svg class="miniload" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
			</div>
			<div class="room_players_other_indiv">
				<svg class="miniload" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
			</div>
        </div>
        </div>
        <div class="right">
            <div class="right_header">
            Room:<?php echo $room->getroomname($_GET['rid']);?>
            </div>
            <div class="right_content r_fixed">
                <div id="map-canvas" class="big_play_content">
                </div>
            </div>
			<div class="gamewarn">

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
<div class="ingamepopup drawcard">
    	<div class="ingamepopup_header">
    	Draw a card
    	</div>
    	<div class="create_room_content">
    	<img src="./img/card.png"><br />
		You are given a chance to draw a special card.<br />
    	<button class="drawbutton">Draw</button>
		<button class="cancel_button">Cancel</button>
    	</div>
    </div>

    <div class="ingamepopup buybuilding">
    	<div class="ingamepopup_header">
    	Buy a building
    	</div>
    	<div class="create_room_content">
    	<img class="buybimg" src=""><br />
    	Name:<b class="building_name"></b><br />
		Price:<b class="building_price">2000</b><br />
    	<button class="buybutton">Buy</button>
		<button class="cancel_button">Cancel</button>
        </div>
    </div>
    <div class="ingamepopup payrent">
    	<div class="ingamepopup_header">
    	Pay rent
    	</div>
    	<div class="create_room_content">
    	<img class="rentimg" src=""><br />
		Owner:<b class="building_owner"></b><br />
		Rent:$<b class="building_rent"></b><br />
    	<button class="paybutton">Pay</button>
        </div>
    </div>
    <div class="ingamepopup mybuilding">
    	<div class="ingamepopup_header">
    	Property
    	</div>
    	<div class="create_room_content showmybuilding">
		<div class="my_small_prop">
    	<img class="rentimg" src="./img/big/station.png"><br />Rent:$100</div>
    </div>
		<button class="cancel_button">Close</button>
    </div> <!-- /container -->
    <div class="ingamepopup verdict">
    	<div class="ingamepopup_header">
		Verdict
    	</div>
    	<div class="create_room_content">
		<ul class="verdict_player">
		</ul>
		<a href="./roomlist.php"><button class="cancel_button">Lobby</button></a>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script src="js/main.js"></script>

        <script>
		$('#dicebutton').prop('disabled', true);
		$('#finishbutton').prop('disabled', true);
var socket;		// WebSocket
var jail = 0;
var gamenotice;
var payto;
var readyToFinish;
var myPlayerNo;
var MY_MAPTYPE_ID = 'custom_style';
var gameStopName = new Array();
gameStopName[0]="University Station";
gameStopName[1]="Chung Chi Administration Building";//CC admin
gameStopName[2]="Wong Fok Yuen Building";//王褔元
gameStopName[3]="Chen Kou Bun Building";//陳國本
gameStopName[4]="Sino building";//信和
gameStopName[5]="CC staff hostel";//CC staff hostel
gameStopName[6]="MMW Engineering Building";//new eng build
gameStopName[7]="Academic Builidng";//教研樓
gameStopName[8]="HSB";//HSB
gameStopName[9]="Shaw Science building";//逸夫科學
gameStopName[10]="Science Centre";//BMSB
gameStopName[11]="Sir Run Run Shaw Hall";//sir run run
gameStopName[12]="Pi Chiu Building"; //pi chu
gameStopName[13]="NA College"; //NA tower
gameStopName[14]="Cheng Ming College";
gameStopName[15]="UC Gym";
gameStopName[16]="UC College";
gameStopName[17]="Lee Shau Kee building";//lsk
gameStopName[18]="Leung Kao Kui building";//lkk
gameStopName[19]="WYS College";//wys
gameStopName[20]="Shaw College";//shaw
gameStopName[21]="Shaw Hostel";//shaw hostel
gameStopName[22]="Jail";//jail
gameStopName[23]="Staff hostel";//staff hostel
gameStopName[24]="Science Park";//science park
gameStopName[25]="AIT";//AIT
gameStopName[26]="YIA";//YIA
gameMarkName = new Array();
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
<?php
foreach($buildingArray as $building){
	echo "var ".$building->name.";";
}
?>
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
var gameStop = new Array();
gameStop[0]=0;
gameStop[1]=3;//CC admin
gameStop[2]=5;//王褔元
gameStop[3]=6;//陳國本
gameStop[4]=6.5;//信和
gameStop[5]=8;//CC staff hostel
gameStop[6]=10.5;//new eng build
gameStop[7]=12.5;//教研樓
gameStop[8]=15.5;//HSB
gameStop[9]=17;//逸夫科學
gameStop[10]=19;//BMSB
gameStop[11]=24.5;//sir run run
gameStop[12]=26; //pi chu
gameStop[13]=31.5; //NA tower
gameStop[14]=33;
gameStop[15]=36;
gameStop[16]=38;
gameStop[17]=42.5;//lsk
gameStop[18]=43.5;//lkk
gameStop[19]=49;//wys
gameStop[20]=51;//shaw
gameStop[21]=55;//shaw hostel
gameStop[22]=66.5;//jail
gameStop[23]=71;//staff hostel
gameStop[24]=86;//science park
gameStop[25]=94.5;//AIT
gameStop[26]=95.5;//YIA
//initialize an array of four players with offset zero.
var count = new Array();
count[0] = 0;
count[1] = 0;
count[2] = 0;
count[3] = 0;
var playerOffset = new Array();
playerOffset[0] = 0;
playerOffset[1] = 0;
playerOffset[2] = 0;
playerOffset[3] = 0;
var playerStopNo = new Array();
playerStopNo[0] = 0;
playerStopNo[1] = 0;
playerStopNo[2] = 0;
playerStopNo[3] = 0;
var line;
var playerRound = new Array();
playerRound[0] = 0;
playerRound[1] = 0;
playerRound[2] = 0;
playerRound[3] = 0;
var map;
var movable = 0;
var payrent = 1;
var stopNoCoord = [
	new google.maps.LatLng(22.41398668736628,114.20978419482708),//大學站
	new google.maps.LatLng(22.41439581682375,114.20845784246922),//CC Admin
	new google.maps.LatLng(22.414921484418553,114.20784629881382),//王褔元
	new google.maps.LatLng(22.415366564624026,114.20760624110699) ,
	new google.maps.LatLng(22.41561947864573,114.20752845704556) ,
	new google.maps.LatLng(22.41627779680755,114.2077524214983) ,//CC
	new google.maps.LatLng(22.417300601321244,114.2081319540739) ,//new eng build
	new google.maps.LatLng(22.417162988061555,114.20722402632236) ,
	new google.maps.LatLng(22.418334556046702,114.20744396746159) ,
	new google.maps.LatLng(22.418633335295212,114.20802064239979) ,
	new google.maps.LatLng(22.41893087415704,114.20898891985416) ,
	new google.maps.LatLng(22.419840843220154,114.20710198581219) ,
	new google.maps.LatLng(22.419840843220154,114.20629061758518) ,
	new google.maps.LatLng(22.420642949970436,114.20820839703083), //NA tower
	new google.maps.LatLng(22.421094210464293,114.20756734907627) ,
	new google.maps.LatLng(22.420602038919093,114.20604787766933) ,
	new google.maps.LatLng(22.420349133970557,114.20504473149776) ,
	new google.maps.LatLng(22.419964816745452,114.2031229287386) ,
	new google.maps.LatLng(22.419958618071814,114.20292042195797) , //LKK
	new google.maps.LatLng(22.42188639223504,114.20258648693562) ,
	new google.maps.LatLng(22.42207111002635,114.20151494443417) , //SHAW
	new google.maps.LatLng(22.423088913046463,114.20101471245289) , //SHAW hostel
	new google.maps.LatLng(22.42580632377871,114.20544371008873) , //jail
	new google.maps.LatLng(22.425343921419284,114.20776315033436) ,
	new google.maps.LatLng(22.41998093329562,114.21285666525364) , //science park
	new google.maps.LatLng(22.416195972121077,114.21140559017658) ,//AIT
	new google.maps.LatLng(22.415822801348867,114.21104215085506) , //YIA
	new google.maps.LatLng(22.413976769061446,114.20978955924511)
	];
function initialize() {
    var mapOptions = {
    center: new google.maps.LatLng(22.4189136, 114.207623),
    zoom: 16,
    mapTypeId: MY_MAPTYPE_ID
};

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

// INCLUDE MAP FILE
<?php echo file_get_contents('maps/cuhk.map.js'); ?>
// END

  // Define the symbol, using one of the predefined paths ('CIRCLE')
  // supplied by the Google Maps JavaScript API.
  var lineSymbol = {
    path: google.maps.SymbolPath.CIRCLE,
    fillColor: '#000',
    fillOpacity: 1.0,
    scale: 12,
    strokeColor: '#393',
    strokeWeight: 8
  };
  var line2Symbol = {
    path: google.maps.SymbolPath.CIRCLE,
    fillColor: '#000',
    fillOpacity: 1.0,
    scale: 12,
    strokeColor: '#eee',
    strokeWeight: 8
  };
  var line3Symbol = {
    path: google.maps.SymbolPath.CIRCLE,
    fillColor: '#000',
    fillOpacity: 1.0,
    scale: 12,
    strokeColor: '#ff0000',
    strokeWeight: 8
  };
  var line4Symbol = {
    path: google.maps.SymbolPath.CIRCLE,
    fillColor: '#000',
    fillOpacity: 1.0,
    scale: 12,
    strokeColor: '#0000ff',
    strokeWeight: 8
  };
  // Create the polyline and add the symbol to it via the 'icons' property.
  line = new google.maps.Polyline({
    path: lineCoordinates,
    geodesic: true,
    strokeColor: '#5293C2',
    strokeOpacity: 0.8,
    strokeWeight: 8,
    icons: [{
      icon: lineSymbol,
      offset: '0%'
    },
    {
      icon: line2Symbol,
      offset: '0%'
    },
    {
      icon: line3Symbol,
      offset: '0%'
    },
    {
      icon: line4Symbol,
      offset: '0%'
    }],
    map: map
  });
var featureOpts = [
    {
      stylers: [
        { hue: '#2c3e50' }
      ]
    }
  ];
  var styledMapOptions = {
    name: 'Custom Style'
  };

  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
  animateCircle(0);
  animateCircle(1);
  animateCircle(2);
  animateCircle(3);
  google.maps.event.addListener(map, 'click', function(e) {
    console.log('new google.maps.LatLng(' + e.latLng.A + ',' +e.latLng.k + ')' );
  });
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP///// 
<?php
foreach($buildingArray as $building){
	echo $building->name . " = new google.maps.Marker({";
	echo " position: new google.maps.LatLng(" . $building->x ."," . $building->y . "),";
	echo " map:map,";
	echo ' icon: "./img/' . $building->img . '",';
	echo ' visible: false';
	echo "});";
	echo "gameMarkName[".$building->stopNo."] = ". $building->name .';';
}
?>
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////

}

function checkProp(playerno){
    if(playerno == null){
        playerno = myPlayerNo;
    }
    var msg={};
    msg.playerno = playerno;
    msg.act = "checkprop";
    msg.rid = <?=$_GET['rid'];?>;
    msg.playerno=myPlayerNo;
    socket.send(JSON.stringify(msg));
}
function cDice(){
    var msg = {};
    msg.act = "dice";
    msg.rid = <?=$_GET['rid'];?>;
    msg.step = 13;
    msg.playerno=myPlayerNo;
    socket.send(JSON.stringify(msg));
}


//finish this round
function finishRound() {
	if(movable == 0 && payrent==1){
        readyToFinish = 1;
		var msg = {};
		msg.rid = <?=$_GET['rid'];?>;
		msg.act = "finishround";
		msg.playerno=myPlayerNo;
		socket.send(JSON.stringify(msg));
		$('#finishbutton').prop('disabled', true);
        $("b[id=show-time]").html(<?=$settings["round_time"];?>);
	}else{
		if(movable == 1){
			if(jail == 1){
				jail++;
				readyToFinish = 1;
				var msg = {};
				msg.rid = <?=$_GET['rid'];?>;
				msg.act = "finishround";
				msg.playerno=myPlayerNo;
				socket.send(JSON.stringify(msg));
				$('#finishbutton').prop('disabled', true);
				$("b[id=show-time]").html(<?=$settings["round_time"];?>);
			}else{
				gameshowmsg('You did not dice!');
			}
		}else{
			if(payrent!=1){
				gameshowmsg('You did not pay rent!');
			}else{
				alert('It is not your turn now');
			}
		}
	}
}

//dice
function pDice(){
	if(movable == 1 && payrent==1 && jail != 1){
		var msg = {};
		msg.act = "dice";
		msg.rid = <?=$_GET['rid'];?>;
		var random=Math.random();
		random=random*6;
		random=parseInt(random)+1;
		msg.step = 22;
		msg.playerno=myPlayerNo;
		socket.send(JSON.stringify(msg));
		movable = 0;
		$('#dicebutton').prop('disabled', true);
		$('.ingamepopup').hide();
	}else{
		if(payrent!=1){
			gameshowmsg('You did not pay rent!');
		}else if(jail == 1){
			gameshowmsg('You are jailed');
			jail++;
			movable = 0;
			$('#dicebutton').prop('disabled', true);
			$('.ingamepopup').hide();
		}else{
			alert('It is not your turn now');
		}
	}
}

//for animation of circle in the googlem ap
function animateCircle(playerNo) {
    window.setInterval(function() {
        playerOffset[playerNo]=playerOffset[playerNo]%100;
        if(count[playerNo]<playerOffset[playerNo]){
            count[playerNo] = (count[playerNo] + 0.5);
        }
        var icons = line.get('icons');
        icons[playerNo].offset = (count[playerNo]) + '%';
        line.set('icons', icons);
        if(count[playerNo]>playerOffset[playerNo]){
            count[playerNo] = (count[playerNo] + 0.5);
            if(count[playerNo]==100){
            	count[playerNo]=0;
            }
            icons[playerNo].offset = (count[playerNo]) + '%';
            line.set('icons', icons);
        }
    }, 20);
  
}

function gameshowmsg(msg){
	$('.gamewarn').html(msg);
	$('.gamewarn').show(300);
	clearTimeout(gamenotice); //clear timer
	gamenotice = setTimeout(function(){
        $('.gamewarn').hide(300);
    },3000); //hide the game message after 3seconds
}

function updatemoney(tempplayerno,tempmoney){  //update user money on the user info area
	$('.room_players_other_indiv').each(function(){
		if($(this).hasClass(''+tempplayerno+'')){  //check if it is the targeted user
			$(this).find('.opmoney').html(eval(tempmoney));
		}
	});
}
google.maps.event.addDomListener(window, 'load', initialize);
            $(document).ready(function(){
				$('svg.bigload').fadeOut(500); //loading animation
				$('.bg1').fadeIn(300);
				$("#p_stop").html(gameStopName[playerOffset[0]]); //initialize the layout only
            	SetupWebSocket();
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
<?php
if(isset($_SESSION['name'])){
?>
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
				$('#send_content_submit').click(function(){
					if($('#send_content').val()==''){ //empty message
						alert('Your message is empty!');
						$('#send_content').focus();
					}else{
                    	var msg = {};
						msg.act = "sendmsg";
						msg.rid = <?=$_GET['rid'];?>;
						msg.uname = '<?= $_SESSION['name'];?>';
                        msg.dname = '<?= $_SESSION['dname'];?>';
						msg.sendcontent=$('#send_content').val();
						socket.send(JSON.stringify(msg));
						$('#send_content').val('');
					}
				});
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
<?php
}
?>
/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////PHP/////
				$('#send_content').bind('keydown', function(e) {
					if(e.keyCode==13){
						$('#send_content_submit').click();
					}
				});
				$('.cancel_button').click(function(){
					$('.ingamepopup').hide();
				});
				$(window).on('beforeunload', function(){
					  var msg = {};
					  msg.act="leavegame";
					  msg.uname = '<?= $_SESSION['name'];?>';
					  msg.rid = <?=$_GET['rid'];?>;
					  socket.send(JSON.stringify(msg));
				});
				$(document).on("keydown", disableF5);

			    var settimmer = 0;
			
				$(function(){
						window.setInterval(function() {
							var timeCounter = $("b[id=show-time]").html();
							if(readyToFinish == 0){
								var updateTime = eval(timeCounter)- eval(1);
							}
							$("b[id=show-time]").html(updateTime);

							if(updateTime == 0){
								//event to be sent
								if(payrent == 0){
									var msg = {};
									msg.act = "payrent";
									msg.payto = payto;
									msg.rid = <?=$_GET['rid'];?>;
									msg.rent = parseInt($('.building_rent').html());
									socket.send(JSON.stringify(msg));
								}
								//TODO: if jail, reduce money, and if money < 0, then he/she loses
								if(movable != 0){
									pDice();
								}
								readyToFinish = 1; //stop the count down
								finishRound();
								$("b[id=show-time]").html(<?=$settings["round_time"];?>);
							}
						}, 1000);
				});
				$('.drawbutton').click(function(){
					$('.ingamepopup').hide();
					var msg = {};
					msg.act = "drawcard";
					msg.playerno = myPlayerNo;
					var random=Math.random()*6; //needed to be modified
					random = parseInt(random)+1;
					msg.cardno = random;
					msg.rid = <?=$_GET['rid'];?>;
					socket.send(JSON.stringify(msg));
				});
            });
			$('.buybutton').click(function(){
				var msg = {};
				msg.act = "buybuilding";
				msg.stopno = playerStopNo[myPlayerNo-1];
				socket.send(JSON.stringify(msg));
				$('.buybuilding').hide();
			});
			$('.paybutton').click(function(){
				var msg = {};
				msg.act = "payrent";
				msg.payto = payto;
				msg.rid = <?=$_GET['rid'];?>;
				msg.rent = parseInt($('.building_rent').html());
				socket.send(JSON.stringify(msg));
			})
			function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
            function SetupWebSocket()
			{
				var host = 'ws://<?=$SERVER_ADDR?>:9876/mono/server.php';
				socket = new WebSocket(host);
				socket.onopen = function(e) { 
					var msg = {};
					msg.act = "getplayerno";
					msg.uname = '<?= $_SESSION['name'];?>';
                    msg.dname = '<?= $_SESSION['dname'];?>';
					msg.rid = <?=$_GET['rid'];?>;
					socket.send(JSON.stringify(msg));
				};
				socket.onmessage = function(e) {
					var retData=$.parseJSON(e.data);
					//console.log(retData["roomlist"].length);
					console.log(retData);	
					if(retData['act']=='playerno'){
						myPlayerNo = retData['playerno'];
						movable = retData['movable'];
						if(myPlayerNo == 1){
							$('#toavatar').css("border-color","#393");
						}else if(myPlayerNo == 2){
							$('#toavatar').css("border-color","#eee");
						}else if(myPlayerNo == 3){
							$('#toavatar').css("border-color","#ff0000");
						}else if(myPlayerNo == 4){
							$('#toavatar').css("border-color","#0000ff");
						}
                        $('#dicebutton').prop('disabled', true);
						if(retData['movable']){
							$('#dicebutton').prop('disabled', false);
							$('#finishbutton').prop('disabled', false);
							
                            readyToFinish = 0;
							gameshowmsg('It is your turn now!');
						}
					}else if(retData['act'] == 'initinfo'){
						var tempplayerno = 0;
						for(i=0;i<retData['players'].length;i++){
							var tempplayer = retData['players'][i];
							if(tempplayer['playerno'] != myPlayerNo){
								$('.room_players_other_indiv:eq('+tempplayerno+')').html('');
								$('.room_players_other_indiv:eq('+tempplayerno+')').addClass(''+tempplayer["playerno"]+'');
								$('.room_players_other_indiv:eq('+tempplayerno+')').html('<img src="./data/'+tempplayer['name']+'.png">'+tempplayer['dname']+'<br />Money: <b class="opmoney">'+tempplayer['money']+'</b> <button onclick="checkProp('+tempplayer['playerno']+')" value="'+ tempplayer['playerno'] +'"class="checkprop">Property</button>');
								tempplayerno++;
							}
						}
					}
					if(retData['act']=='transfer'){
						var tempno=parseInt(retData.playerno)-1;  //remember to -1= =
						playerOffset[tempno]=parseFloat(retData.offset);
						var thisround=Math.floor(retData.offset/27);
						
						if(tempno==myPlayerNo-1){ //to be edited
							if(thisround>playerRound[tempno]){
								//gameshowmsg('You pass one round');  //to be edited
								playerRound[tempno]++;
								var msg = {};
								msg.act = "addround";
								msg.rid = <?=$_GET['rid'];?>;
                                msg.playround = playerRound[tempno];
								msg.playerno = myPlayerNo;
								socket.send(JSON.stringify(msg));
								//$("#p_money").html(eval($("#p_money").html())+eval(<?=$settings["round_money"];?>)); //add money
							}
						}

						playerOffset[tempno] = playerOffset[tempno]%27;
						var stopNo = playerOffset[tempno];
						playerStopNo[tempno] = stopNo;
						map.panTo(stopNoCoord[stopNo]);
						//send back the stopNO to server//
						if(tempno==myPlayerNo-1){ 
							var msg = {};
							msg.act = "recordstopno";
							msg.playerno = myPlayerNo;
							msg.stopno = stopNo;
							msg.rid = <?=$_GET['rid'];?>;
							socket.send(JSON.stringify(msg));
						}
						var tempstop = playerOffset[tempno]%27;
						playerOffset[tempno] = gameStop[playerOffset[tempno]];
						//alert(playerOffset[tempno]);
						//console.log(retData.uname);
						if(tempno==myPlayerNo-1){
							$("#p_stop").html(gameStopName[tempstop]); //update the stop name
						}
						gameshowmsg(retData['uname'] +' moves to '+ gameStopName[tempstop]);
						$('.chat_box').append('<b class="systemmsg">[SYSTEM] : '+retData['uname'] +' moves to '+ gameStopName[tempstop]+'.</b><br />');
						$('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
						if(playerOffset[tempno]==66.5 && tempno==myPlayerNo-1){//to be edited(same playerno)
							var msg={};
							msg.act = "jail";
							msg.playerno = myPlayerNo;
							socket.send(JSON.stringify(msg));
							gameshowmsg('You are jailed');
							jail = 1;
						}

					}else if(retData['act']=='getoffnow'){
						alert('Get out now');
						window.location.href = './roomlist.php';
					}else if(retData['act']=='getcard'){
						if(retData['playerno'] == myPlayerNo){
							gameshowmsg('You ' + retData['cardmsg']);
							$("#p_money").html(eval(retData['money'])); //add money
						}else{
							alert(retData['cardpname'] +' '+ retData['cardmsg']);
							updatemoney(retData['playerno'],retData['money']);
						}
						gameshowmsg(retData['cardpname'] +' '+ retData['cardmsg']);
						$('.chat_box').append('<b class="systemmsg">[SYSTEM] : '+retData['cardpname'] +' '+ retData['cardmsg']+'</b><br />');
						$('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
					}else if(retData["act"]=="chatroommsg"){
						$('.chat_box').append(retData["uname"]+" : "+retData["sendcontent"]+" ["+retData["stime"]+"]<br />");
						$('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
					}else if(retData["act"]=="recordstopno"){
						//console.log('here'+ retData["marker"]);
						if(retData["playerno"] == myPlayerNo){
							$('.building_name').html(retData["bname"]);
							$('.building_price').html(retData["money"]);
							$('.buybimg').attr('src', "./img/big/"+retData['img']);
							$('.buybuilding').show();
						}
					}else if(retData["act"]=="nextmovable"){
						if(myPlayerNo == retData["nextplayerno"]){
							movable = 1;
							$('#dicebutton').prop('disabled', false);
							gameshowmsg('It is your turn now!');
							$('#finishbutton').prop('disabled', false);
							readyToFinish = 0;
						}
					}else if(retData["act"] == "notice"){
						tempMN = null;
						if(retData['playerno'] == myPlayerNo){
							$("#p_money").html(eval(retData['money'])); 
						}else{
							updatemoney(retData['playerno'],retData['money']);
						}
                        if(retData['bought']==1){
						  tempMN = gameMarkName[playerStopNo[retData['playerno']-1]];
                        }
						if(tempMN){
							tempMN.visible=true;
							tempMN.setMap(map);
						}
						if(retData["sendcontent"]){
							gameshowmsg(retData["sendcontent"]);
							$('.chat_box').append('<b class="systemmsg">[SYSTEM] : ' + retData["sendcontent"] + "</b><br />");
							$('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
						}
					}else if(retData["act"] == "takerent"){
						payrent = 0;
						console.log(retData);
						payto = retData["payto"];
						$('.building_rent').html(retData["rent"]);
						$('.building_owner').html(retData["name"]);
						$('.rentimg').attr('src', "./img/big/"+retData['img']);
						$('.payrent').show();
					}else if(retData["act"] == "mybuilding"){
						
						if(retData["mybuilding"].length == 0){
							alert("You have no property");
						}else{
							$('.mybuilding').show();
							myprops = retData["mybuilding"];
							$('.showmybuilding').html('');
							for(i=0;i<myprops.length;i++){
								$('.showmybuilding').append('<div class="my_small_prop"><img class="rentimg" src="./img/big/'+myprops[i]['img']+'"><br />Rent:$'+myprops[i]['rent']+'</div>');
							}
						}
					}else if(retData["act"] == "getchance"){
						$('.drawcard').show(); //get a chance to draw a card.
					}else if(retData["act"] == "payrentsucceed"){
						if(myPlayerNo == retData['playerno']){
							$('.payrent').hide();
							$('#p_money').html(eval(retData['money']));
							payrent = 1;
						}else{
							updatemoney(retData['playerno'],eval(retData['money']));
						}
						if(myPlayerNo == retData['otherplayerno']){
							$('.payrent').hide();
							$('#p_money').html(eval(retData['othermoney']));
							payrent = 1;
						}else{
							updatemoney(retData['otherplayerno'],eval(retData['othermoney']));
						}
					}else if(retData["act"] == "selfwarn"){
						gameshowmsg(retData["sendcontent"]);
					}else if(retData["act"] == "endgame"){
                        console.log(retData);
						$('.verdict').show();
						$('.verdict_player').html('');
						var p = 1;
						for(i=retData["players"].length-1;i>=0;i--){
							$('.verdict_player').append('<li>'+(p++)+' <img src="./data/'+retData["players"]["name"]+'.png"> '+retData["players"][i]["dname"]+' $'+retData["players"][i]["money"]+'</li>');
						}
						$('#dicebutton').prop('disabled', true);
						$('#finishbutton').prop('disabled', true);
						readyToFinish = 1;
                    }
				};
				socket.onclose = function(e) {
					gameshowmsg('Disconnected - status ' + this.readyState); 
					//alert('Disconnected - status ' + this.readyState); 
				};
			}
        </script>
    </body>
</html>
