<?php
require '../database.php';
require '../class/user.php';

	session_start();
	$user=new User($db);
	$data = $user->userinfo($_SESSION['uid']);
	$email = $_POST['email'];

	// edit below
	$from = "Do Not Reply";
	$fromemail = "do-not-reply@b5.hk";

	$subject = "Wealthy Family Monopoly - Invitation";
	$body = "Play Monopoly Together!\n\n";
	$body .= "Your friend " . $_SESSION['dname'] ." is playing Wealthy Family Monopoly. Come and join us!\n";
	$body .= "Click the link below and register. You and your friend will get great bonus!\n\n";
	$body .= "http://".$_SERVER['SERVER_NAME']."/mono/register.php?referLink=".$data['referLink'];
	$body .= "\n\nRegards,\nTeam Monopoly\nCUHK";
	
	
	// send code, do not edit unless you know what your doing
	$header = "Reply-To: Administrator <admin@b5.hk>\r\n"; 
    $header .= "Return-Path: Administrator <admin@b5.hk>\r\n"; 
    $header .= "From: $from <$fromemail>\r\n"; 
    $header .= "Organization: Team Monopoly\r\n"; 
    $header .= "Content-Type: text/plain\r\n"; 
 
    mail("$email", "$subject", "$body", $header);
	echo "Invitation Email has sent";
?>