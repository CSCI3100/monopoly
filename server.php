#!/php -q
<?php  /*  >php -q server.php  */
require './database.php';
require './config.php';
$debug = true;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();
date_default_timezone_set('Asia/Hong_Kong');
$sock = WebSocket("0.0.0.0",9876);
$sockets = array($sock);
$users = array();
$playroom = array();
$logfile = date("Y-m-d").".log";
if (file_exists($logfile)) {
    //nothing to do
}else{
    $handle = fopen("./log/".$logfile, 'wa') or die('Cannot open file:  '.$logfile);
    fclose($handle);
}

while(true)
{
	$read = $sockets;
	
	$write = NULL;
	$except = NULL;
	if (socket_select($read, $write, $except, NULL) < 1)
		continue;
	
	if (in_array($sock, $read)) 
	{
		$newsock = socket_accept($sock);
		connect($newsock);
		
		$key = array_search($sock, $read);
		unset($read[$key]);
	}
	
	foreach($read as $socket)
	{
		$bytes = @socket_recv($socket, $buffer, 2048, 0);
		
		if($bytes == 0)
		{
			disconnect($socket); 
		}
		else
		{
			$user = getuserbysocket($socket);
			if(!$user->handshake)
			{ 
				dohandshake($user,$buffer);
				console("User ".$user->id." Connected!");
				send($user->socket,"You are connected. ID = ".$user->id."<br/>");
				#global_msg("[GLOBAL MESSAGE] User ".$user->id." logged in!<br/>");
			}
			else
			{ 
				#console("\nprocess -> id: " . $user->id);
				#process($socket,$buffer);
				
				$val = json_decode(unmask($buffer),true);
				#console(var_dump(mysql_real_escape_string($val['message'])));
				//disconnect user!!!!!!!!!!!!!!!!!!!!!!! anti double login
				if(isset($val['uname'])){
					foreach ($users as $u){
						if($val['uname'] == $u->name){
							if($u->id != $user->id){
								disconnect($u->socket);
							}
						}
					}
				}
				
				switch($val['act']){
					case "init":
					foreach ($users as $u) {
						if($u->id == $user->id){
							$u->name = $val['uname'];
						}
					}
					console("[GLOBAL MESSAGE] User ".$user->name." logged in!<br/>");
					break;
					case "getroomlist":
					console(var_dump($val));
					$room = new Room($db);
					foreach ($users as $u) {
						if($u->id == $user->id){
							$u->name = $val['uname'];
						}
					}
					foreach ($users as $u) {
						if($u->name == $val['uname']){
							if($u->rid>0){
								$room->leaveroom($u->rid);
								$u->rid = 0; //should not be in any room
							}
						}
					}
					$send_packet=array();
					$send_packet["act"]="roomlist";
					foreach ($users as $u) {
						if($u->id == $user->id){
							if($u->rid>0){
								$room->leaveroom($u->rid);
								$u->rid = 0; //should not be in any room
							}
						}
					}
					//console(var_dump($users));
					$send_packet["roomlist"]=$room->getroomlist($val['page']);
					send($user->socket,json_encode($send_packet));
                    update_player_list();
					break;
					case "createroom":
					console(var_dump($val));
					$room = new Room($db);
					$lastroomID=$room->createroom($val['roomname'],$val['password']);
					$send_packet=array();
					$send_packet["act"]="transferroom";
					$send_packet["rid"]=$lastroomID;
					console(var_dump($send_packet));
					send($user->socket,json_encode($send_packet));
					break;
					case "enterroom":
					console(var_dump($val));
					foreach ($users as $u) {
						if($u->id == $user->id){
							$u->name = $val['uname'];
						}
					}
					$room = new Room($db);
					foreach ($users as $u) {
						if($u->name == $user->name && $u->id != $user->id){
							if($u->rid>0){
								$room->leaveroom($u->rid);
								$u->rid = 0; //should not be in any room
							}
						}
						if($u->id == $user->id){
							if($u->rid>0){
								$room->leaveroom($u->rid);
								$u->rid = 0; //should not be in any room
							}
							$u->name = $val['uname'];
							$u->rid = $val['rid'];
							$u->state=0;
							$u->playerno = ($room->gettotalplayer($val['rid'])+1);
							$room->addplayer($val['rid']);
							break;
						}
					}
					$room_player = array();
					foreach ($users as $u) { //retrieve a list of player in the room
						if($u->rid == $val['rid']){
							$tempuser = new tempUser($u);
							array_push($room_player,$tempuser);
							$tempuser = null;
						}
					}
					console(var_dump($room_player));
					$send_packet=array();
					$send_packet["act"]="roomplayer";
					$send_packet["players"]=$room_player;
					//console(json_encode($send_packet));
					room_msg($val['rid'],json_encode($send_packet));
					//console(var_dump($room_player));
					$send_packet=array();//another packet for all users
					$send_packet["act"]="roomlist";
					$send_packet["roomlist"]=$room->getroomlist(1);
					global_msg(json_encode($send_packet));
					break;
					case "getready":
                        console(var_dump($val));
                        foreach ($users as $u) {
                            if($u->id == $user->id){
                                $u->state=1;
                                console(var_dump($u));
                                break;
                            }
                        }

                        $checktotal = 0;
                        $room_player = array();
                        foreach ($users as $u) { //retrieve a list of player in the room
                            if($u->rid == $val['rid']){
                                $checktotal++;
                                $tempuser = new tempUser($u);
                                array_push($room_player,$tempuser);
                                $tempuser = null;
                            }
                        }
                        $send_packet=array();
                        $send_packet["act"]="roomplayer";
                        $send_packet["players"]=$room_player;
                        $send_packet["totalnum"] = $checktotal;
                        room_msg($val['rid'],json_encode($send_packet));
                        //global_msg(json_encode($send_packet));//needed to be modified to send to specific people in that room
                        console(var_dump($room_player));
					break;
					case "leaveroom":
					console(var_dump($val));
					$room = new Room($db);
					foreach ($users as $u) {
						if($u->name == $val['uname']){
							if($u->rid>0){
								$temprid=$u->rid;
								$room->leaveroom($u->rid);
								$u->rid = 0; //should not be in any room
							}
						}
					}
					$room_player = array();
					foreach ($users as $u) { //retrieve a list of player in the room
						if($u->rid == $temprid){
							$tempuser = new tempUser($u);
							array_push($room_player,$tempuser);
							$tempuser = null;
						}
					}
					//console(var_dump($user));
					$send_packet=array();
					$send_packet["act"]="roomplayer";
					$send_packet["players"]=$room_player;
					console("The room id is".$temprid);
					console(var_dump($room_player));
					room_msg($temprid,json_encode($send_packet));
					$send_packet=array();//another packet for all users
					$send_packet["act"]="roomlist";
					$send_packet["roomlist"]=$room->getroomlist(1);
					global_msg(json_encode($send_packet));
					break;
					case "sendmsg":
					console(var_dump($val));
					$send_packet=array();
					$send_packet["act"]="chatroommsg";
					$send_packet["uname"]=$val['uname'];
					$send_packet["stime"]= date('H:i');
					$send_packet["sendcontent"]=htmlspecialchars($val['sendcontent']);
					if($val['rid']>0){  //if rid>0, it is a room message
						room_msg($val['rid'],json_encode($send_packet));
					}else{
						global_msg(json_encode($send_packet));
					}
					break;
					case "dice":
					console(var_dump($val));
					$send_packet = array();
					$send_packet["act"] = "transfer";
					$user->offset+=$val['step'];
					$send_packet["uname"] = $user->name;
					$send_packet["offset"] = $user->offset;
					$send_packet["money"] = $user->money;
					$send_packet["playerno"] = $val["playerno"];
					room_msg($val['rid'],json_encode($send_packet));
					$send_packet = array();
					$send_packet["act"] = "nextmovable";
					if($val['playerno']<4){
						$send_packet['nextplayerno'] = $val['playerno']+1;
					}else{
						$send_packet['nextplayerno'] = 1;
					}
					room_msg($val['rid'],json_encode($send_packet));
					break;
					case "getplayerno":
					$user->rid = $val['rid'];
					$user->name = $val['uname'];
					$boolfindroom=0;
					foreach($playroom as $pr){ //finding the corresponding room
						if($pr->rid == $val['rid']){
							$send_packet=array();
							if($pr->counter<=4){
								$send_packet["act"]="playerno";
								$send_packet["playerno"]=$pr->counter;
								$user->playerno = $send_packet["playerno"];
								$user->room = $pr;
							}else{
								$send_packet["act"]="getoffnow";
							}
							$pr->counter=$pr->counter+1;
							$send_packet["movable"] = 0;
							array_push($pr->players, $user);
							send($user->socket,json_encode($send_packet));
							$boolfindroom=1;
						}
					}
					if($boolfindroom==0){ //room not created
						$newRoom = new playRoom($val['rid']);
						array_push($playroom, $newRoom);
						$send_packet = array();
						$send_packet["act"] = "playerno";
						$send_packet["playerno"] = $newRoom->counter;
						$user->playerno = $send_packet["playerno"];
						$newRoom->counter = $newRoom->counter+1;
						$send_packet["movable"] = 1;
						$user->room = $newRoom;
						array_push($newRoom->players, $user);
						send($user->socket,json_encode($send_packet));
					}
					console(var_dump($playroom));
					$send_packet = array();
					$templist = array();
					foreach($user->room->players as $player){
						$tempPlayer = new tempUser($player);
						array_push($templist, $tempPlayer);
						$tempuser = null;
					}
					$send_packet['act'] = "initinfo";
					$send_packet['players'] = $templist;
					room_msg($val['rid'],json_encode($send_packet));
					break;
					case "addround":
					console(var_dump($val));
					$user->money+=$settings["round_money"]; //add money for passing one round
					console(var_dump($user));
					$send_packet=array();
					$send_packet['act'] = "notice";
					$send_packet['playerno'] = $user->playerno;
					$send_packet['money'] = $user->money;
					room_msg($user->rid,json_encode($send_packet));
					break;
					case "drawcard":
					console(var_dump($val));
					$send_packet=array();
					$send_packet['act']="getcard";
					$send_packet['cardpname']=$user->name;
					$send_packet['playerno']=$val['playerno'];
						switch($val['cardno']){
							case "1":
								$send_packet['cardmsg']="gets $500";
								$user->money+=500;
							break;
							case "2":
								$send_packet['cardmsg']="gets $600";
								$user->money+=600;
							break;
							case "3":
								$send_packet['cardmsg']="gets $400";
								$user->money+=400;
							break;
							case "4":
								$send_packet['cardmsg']="gets $300";
								$user->money+=300;
							break;
							case "5":
								$send_packet['cardmsg']="gets $800";
								$user->money+=800;
							break;
							case "6":
								$send_packet['cardmsg']="loses $500";
								$user->money-=500;
							break;
						}
						console(var_dump($users));
						$send_packet['money']=$user->money;
						room_msg($val['rid'],json_encode($send_packet));
					break;
					case "recordstopno":
						console(var_dump($val));
						$soldout = 0;
						$foundbuilding = null;
						foreach($buildingArray as $building){
							if($building->stopNo == $val['stopno']){
								foreach($user->room->relations as $relation){
									if($building->stopNo == $relation->stopno){
										$foundbuilding = $relation;
										$soldout = 1;
									}else{
										$soldout = 0;
									}
									break;
								}
								if($soldout == 0){
									$send_packet=array();
									$send_packet['playerno']=$user->playerno;
									$send_packet['act']="recordstopno";
									$send_packet['marker']=$building->stopNo;
									$send_packet['bname']=$building->rname;
									$send_packet['money'] = $building->price;
									$send_packet['img'] = $building->img;
									room_msg($val['rid'],json_encode($send_packet));
									//to be done
								}else{ //charge rent!
									if($foundbuilding->playerno != $user->playerno){
										$send_packet=array();
										console("hihi i need rent");
										$send_packet['act'] = "takerent";
										$send_packet['payto'] = $foundbuilding->playerno;
										$send_packet['img'] = $foundbuilding->img;
										$send_packet['name'] = $foundbuilding->name;
										$send_packet['rent'] = $foundbuilding->rent;
										console(var_dump($send_packet));
										send($user->socket,json_encode($send_packet));
									}
								}
								break;
							}
						}
						//console("my name is".$user->name);
						if(in_array($val['stopno'],$luckArray)){
							$send_packet=array();
							$send_packet['act'] = "getchance";
							send($user->socket,json_encode($send_packet));
						}
					break;
					case "buybuilding":
						console(var_dump($val));
						console(var_dump($user->room));
						$send_packet['bought'] = 0;
						foreach($buildingArray as $building){
							if($building->stopNo == $val['stopno']){
								//transaction begin;
								if($user->money >= $building->price){
									$user->money -= $building->price;
									$newRelation = new relation();
									$newRelation->playerno = $user->playerno;
									$newRelation->stopno = $building->stopNo;
									$newRelation->img = $building->img;
									$newRelation->rent = $building->rent;
									$newRelation->name = $user->name;
									array_push($user->room->relations, $newRelation);
									console(var_dump($user));
									console(var_dump($user->room));
									$send_packet = array();
									$send_packet['act'] = "notice";
									$send_packet['playerno'] = $user->playerno;
									$send_packet['money'] = $user->money;
									$send_packet['sendcontent'] = $user->name . " has purchased ". $building->rname;
									$send_packet['bought'] = 1;
									room_msg($user->rid,json_encode($send_packet));
								}else{ //no money to buy
									$send_packet = array();
									$send_packet['act'] = "selfwarn";
									$send_packet['sendcontent'] = "You do not have enough money";
									send($user->socket,json_encode($send_packet));
								}
								console(var_dump($user));
								break;
							}
						}
					break;
					case "payrent":
						console("The rent is ".$val['rent']);
						if($user->money > $val['rent']){
							console(var_dump($user->room));
							foreach($user->room->players as $player){
								if($player->playerno == $val['payto']){
									$player->money += $val['rent'];
									$tempmoney = $player->money;
									break;
								}
							}
							$user->money -= $val['rent'];
							$send_packet = array();
							$send_packet['playerno'] = $user->playerno;
							$send_packet['otherplayerno'] = $val['payto'];
							$send_packet['othermoney'] = $tempmoney;
							$send_packet['act'] = "payrentsucceed";
							$send_packet['money'] = $user->money;
							room_msg($val['rid'],json_encode($send_packet));
						}else{
							console("You do have enough money");
							//TODO:implement not enough money for paying rent
						}
					break;
					case "checkprop": //check my property
                        $mybuilding = array();
                        foreach($user->room->relations as $relation){
                            if($relation->playerno == $user->playerno){
                                //var_dump($relation);
                                array_push($mybuilding, $relation);
                            }
                        }
                        $send_packet = array();
                        $send_packet['act'] = "mybuilding";
                        $send_packet['mybuilding'] = $mybuilding;
                        send($user->socket,json_encode($send_packet));
					break;
				}
			}
		}
	}
	
}

//---------------------------------------------------------------

function update_player_list(){
    global $users;
    $allusers = array();
    foreach($users as $u){
        $tempUser = new tempUser($u);
        array_push($allusers, $tempUser);
    }
    $send_packet = array();
    $send_packet['players'] = $allusers;
    $send_packet['act'] = "userinfo";
    $msg = json_encode($send_packet);
    foreach ($users as $u) {
        if($u->rid == 0){
            send($u->socket,$msg);
        }
    }
    $logfile = date("Y-m-d").".log";
    $handle = fopen("./log/".$logfile, 'a') or die('Cannot open file:  '.$logfile);
    $msg = date("D M j G:i:s T Y") ."\n" .  $msg . "\n";
    fwrite($handle, $msg);
    fclose($handle);
}
function room_msg($rid,$msg){ //send message to a specific room
	global $users;
	foreach ($users as $u){
		if($u->rid == $rid){
			send($u->socket,$msg);
		}
	}
    $logfile = date("Y-m-d").".log";
    $handle = fopen("./log/".$logfile, 'a') or die('Cannot open file:  '.$logfile);
    $msg = date("D M j G:i:s T Y") ."\n" .  $msg . "\n";
    fwrite($handle, $msg);
    fclose($handle);
}

function global_msg($msg){
	global $users;
	foreach ($users as $u) {
		send($u->socket,$msg);
	}
    $logfile = date("Y-m-d").".log";
    $handle = fopen("./log/".$logfile, 'a') or die('Cannot open file:  '.$logfile);
    $msg = date("D M j G:i:s T Y") ."\n" .  $msg . "\n";
    fwrite($handle, $msg);
    fclose($handle);
}

function doTest($socket)
{
	while(true) {
		console("[doTest] " . $socket);
		$sendText = date('Y-m-d H:i:s');
		
		// �p�G�e���ѴN����
		if (!send($socket, $sendText)) {
			echo "[doTest] Stop \n";
			return;
		}
		sleep(1);
	}
}

function process($socket,$msg)
{
	// �T���ݭn�ѽX
	$action = unmask($msg);
	console("< " . $action);
}

/**
 * Unmask a received recvMsg
 * @param $payload
 */
function unmask($recvMsg) 
{
	// ord �^�� ascii code
	// 127 �� 0x01111111
	$length = ord($recvMsg[1]) & 127;
	
	if($length == 126) 
	{
		$masks = substr($recvMsg, 4, 4);
		$data = substr($recvMsg, 8);
	}
	elseif($length == 127) 
	{
		$masks = substr($recvMsg, 10, 4);
		$data = substr($recvMsg, 14);
	}
	else 
	{
		$masks = substr($recvMsg, 2, 4);
		$data = substr($recvMsg, 6);
	}
	
	$text = '';
	for ($i = 0; $i < strlen($data); ++$i) 
	{
		$text .= $data[$i] ^ $masks[$i % 4];
	}
	return $text;
}

function send($client, $msg)
{
	#console("> " . $msg);
	$sendMsg = encode($msg);
	$result = socket_write($client, $sendMsg, strlen($sendMsg));
	
	if ( !$result ) 
	{
		disconnect($client);
		$client = false;
		return false;
	}
	return true;
}


/**
 * Encode a text for sending to clients via ws://
 * @param $text
 */
function encode($text) 
{
	$header = " ";
	$header[0] = chr(0x81);
	$header_length = 1;
	
	//Payload length:  7 bits, 7+16 bits, or 7+64 bits
	$dataLength = strlen($text);
	
	//The length of the payload data, in bytes: if 0-125, that is the payload length.  
	if($dataLength <= 125)
	{
		$header[1] = chr($dataLength);
		$header_length = 2;
	}
	elseif ($dataLength <= 65535)
	{
		// If 126, the following 2 bytes interpreted as a 16
		// bit unsigned integer are the payload length. 
		
		$header[1] = chr(126);
		$header[2] = chr($dataLength >> 8);
			  $header[3] = chr($dataLength & 0xFF);
			  $header_length = 4;
	}
	else
	{
		// If 127, the following 8 bytes interpreted as a 64-bit unsigned integer (the 
		// most significant bit MUST be 0) are the payload length. 
		$header[1] = chr(127);
		$header[2] = chr(($dataLength & 0xFF00000000000000) >> 56);
		$header[3] = chr(($dataLength & 0xFF000000000000) >> 48);
		$header[4] = chr(($dataLength & 0xFF0000000000) >> 40);
		$header[5] = chr(($dataLength & 0xFF00000000) >> 32);
		$header[6] = chr(($dataLength & 0xFF000000) >> 24);
		$header[7] = chr(($dataLength & 0xFF0000) >> 16);
		$header[8] = chr(($dataLength & 0xFF00 ) >> 8);
		$header[9] = chr( $dataLength & 0xFF );
		$header_length = 10;
	}
	return $header . $text;
}


function WebSocket($address,$port)
{
	$master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)     or die("socket_create() failed");
	socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1)  or die("socket_option() failed");
	socket_bind($master, $address, $port)                    or die("socket_bind() failed");
	socket_listen($master, 20)                               or die("socket_listen() failed");
	echo "Server Started : " . date('Y-m-d H:i:s') . "\n";
	echo "Master socket  : " . $master . "\n";
	echo "Listening on   : " . $address . " port " . $port . "\n\n";
	return $master;
}

function connect($socket)
{
	global $sockets,$users,$settings;
	$newUser = new socketUser($settings["start_money"]);
	$newUser->id = uniqid();
	$newUser->socket = $socket;
	$newUser->offset=0; //initalize the offset here
	array_push($users,$newUser);
	array_push($sockets,$socket);
	console("id:" . $newUser->id . ", " . $socket . " CONNECTED!");
}

function disconnect($socket)
{
	global $sockets,$users,$db, $playroom;
	$found = null;
	$n = count($users);
	for($i=0; $i < $n; $i++)
	{
		if($users[$i]->socket == $socket)
		{ 
			$found = $i; 
			//console(var_dump($users[$i]));	
			$room = new Room($db);
			if($users[$i]->rid>0){//kick the user out of the room
				$room->leaveroom($users[$i]->rid);
				foreach($playroom as $proom){
					if($proom->rid == $users[$i]->rid){
						foreach($proom->players as $key => $kplayer){
							if($users[$i]->name == $kplayer->name){
								console("the name is:".$kplayer->name);
								console("the second name is:".$users[$i]->name);
								unset($proom->players[$key]);
							}
						}
					}
					break;
				}
				console("please:".var_dump($playroom));
				$users[$i]->rid = 0; //should not be in any room
				$send_packet=array();//another packet for all users
				$send_packet["act"]="roomlist";
				$send_packet["roomlist"]=$room->getroomlist(1);
				global_msg(json_encode($send_packet));
			}
			break; 
		}
	}
	if(!is_null($found))
	{ 
		array_splice($users, $found, 1); 
	}
	$index = array_search($socket,$sockets);
	socket_close($socket);
	//foreach ($users as $u) {
		//send($u->socket,"[GLOBAL MESSAGE] User ".$users[$found]->id." disconnect!<br/>");
	//}
	console($socket." DISCONNECTED!");
	if($index >= 0)
	{ 
		array_splice($sockets, $index, 1); 
	}
    update_player_list(); //update the player list
}

function dohandshake($user,$buffer)
{
	console("\nRequesting handshake...");
	#console($buffer);
	
	list($resource,$host,$origin,$strkey,$data) = getheaders($buffer);
	if (strlen($strkey) == 0) 
	{
		socket_close($user->socket);
		console('failed');
		return false;
	}
	
	$hash_data = base64_encode(sha1($strkey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
	
	$upgrade  = "HTTP/1.1 101 WebSocket Protocol Handshake\r\n" .
	      "Upgrade: webSocket\r\n" .
	      "Connection: Upgrade\r\n" .
	      "WebSocket-Origin: " . $origin . "\r\n" .
	      "WebSocket-Location: ws://" . $host . $resource . "\r\n" .
	      "Sec-WebSocket-Accept:" . $hash_data . "\r\n\r\n";
	
	socket_write($user->socket, $upgrade, strlen($upgrade));
	$user->handshake = true;
	#console($upgrade);
	console("Done handshaking...\n");
	
	

	return true;
}


function getheaders($req)
{
	$r=$h=$o=$key=$data=null;
	if(preg_match("/GET (.*) HTTP/"               ,$req,$match)){ $r=$match[1]; }
	if(preg_match("/Host: (.*)\r\n/"              ,$req,$match)){ $h=$match[1]; }
	if(preg_match("/Origin: (.*)\r\n/"            ,$req,$match)){ $o=$match[1]; }
	if(preg_match("/Sec-WebSocket-Key: (.*)\r\n/" ,$req,$match)){ $key=$match[1]; }
	if(preg_match("/\r\n(.*?)\$/"                 ,$req,$match)){ $data=$match[1]; }
	
	return array($r,$h,$o,$key,$data);
}

function getuserbysocket($socket)
{
	global $users;
	$found=null;
	foreach($users as $user)
	{
		if($user->socket==$socket)
		{ 
			$found=$user; 
			break; 
		}
	}
	return $found;
}

function    wrap($msg = ""){ return chr(0) . $msg . chr(255); }
function  unwrap($msg = ""){ return substr($msg, 1, strlen($msg) - 2); }


function console($msg = ""){
    global $debug;
    if($debug) {
        echo $msg . "\n";
    }
}

class socketUser
{
	var $id;
	var $socket;
	var $handshake;
	var $online;
	var $name;
	var $rid=0;
	var $state=0;
	var $playerno;
	var $money;
	var $offset=0;
	var $room;
    public function __construct($money){
        $this->money = $money;
    }
}
class tempUser {
	var $id;
	var $name;
	var $rid=0;
	var $state=0;
	var $playerno;
	var $money=1500;
	var $offset=0;
	public function __construct($user){
		$this->id=$user->id;
		$this->name=$user->name;
		$this->rid=$user->rid;
		$this->state=$user->state;
		$this->playerno=$user->playerno;
		$this->money=$user->money;
		$this->offset=$user->offset;
	}
}
class playRoom {
	var $rid;
	var $counter=1;
	var $players;
	var $relations;
	public function __construct($rid){
		$this->rid = $rid;
		$this->players = array();
		$this->relations = array();
	}
}
?>