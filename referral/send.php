<?php

require '../database.php';
require '../class/user.php';

	session_start();
	$user=new User($db);
	$data = $user->userinfo($_SESSION['uid']);
	$email = $_POST['email'];
/*   PHP MAIL
	// edit below
	$from = "Do Not Reply";
	$fromemail = "do-not-reply@b5.hk";

	$subject = "Wealthy Family Monopoly - Invitation";
*/
	$body = "Play Monopoly Together!\n\n";
	$body .= "Your friend " . $_SESSION['dname'] ." is playing Wealthy Family Monopoly. Come and join us!\n";
	$body .= "Click the link below and register. You and your friend will get great bonus!\n\n";
	$body .= "http://".$_SERVER['SERVER_NAME']."/register.php?referLink=".$data['referLink'];
	$body .= "\n\nRegards,\nTeam Monopoly\nCUHK";
	
/*	
	// send code, do not edit unless you know what your doing
	$header = "Reply-To: Administrator <admin@b5.hk>\r\n"; 
    $header .= "Return-Path: Administrator <admin@b5.hk>\r\n"; 
    $header .= "From: $from <$fromemail>\r\n"; 
    $header .= "Organization: Team Monopoly\r\n"; 
    $header .= "Content-Type: text/plain\r\n"; 
 
    mail("$email", "$subject", "$body", $header);
 */

    $url = 'http://sendgrid.com/';
 	$user = 'azure_b72e71991371237cefc7f451149bdd9d@azure.com';
 	$pass = '6OZC0Za20fq8Y5s';

 	$params = array(
      'api_user' => $user,
      'api_key' => $pass,
      'to' => $email,
      'subject' => "Wealthy Family Monopoly - Invitation",
      'text' => $body,
      'from' => 'do-not-reply@b5.hk',
   	);

 	$request = $url.'api/mail.send.json';
 	$session = curl_init($request);
 	curl_setopt ($session, CURLOPT_POST, true);
 	curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
 	curl_setopt($session, CURLOPT_HEADER, false);
 	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
 	curl_exec($session);
 	curl_close($session);


	echo "Invitation Email has sent";
?>