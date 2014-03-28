<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	$email = $_POST['email'];
	
	// edit below
	$from = "Monopoly";
	$fromemail = "zero_ykk@yahoo.com.hk";
	$reply = "this is the email that receives the replies";
	
	$subject = "Monopoly Referral Email";
	$body = "Referral Link - Get more Friends and Premium Tools!\n\n
			Thank you to invite your friends to join Monopoly!
			In order to invite your friends, please click here:\n
			www.google.com";
	
	
	// send code, do not edit unless you know what your doing
	$header .= "Reply-To: Support <$reply>\r\n"; 
    $header .= "Return-Path: Support <$reply>\r\n"; 
    $header .= "From: $from <$fromemail>\r\n"; 
    $header .= "Organization: getFreexBoxLiveCodes\r\n"; 
    $header .= "Content-Type: text/plain\r\n"; 
 
    mail("$email", "$subject", "$body", $header);
	echo "Monopoly Referral Email has sent";
?>

</body>
</html>