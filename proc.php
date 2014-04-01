<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require './database.php';
require './class/user.php';
       session_start();
		$user=new User($db);
		$data = $user->userinfo($_SESSION['uid']);
	   	if($_POST['one']*1+$_POST['double']*3+$_POST['cash']*2<$data['money']){
    		$user->buy($_POST['one'],$_POST['double'],$_POST['cash'],$_SESSION['uid']);
    		echo 'Success!';
		}else{
			echo 'Failure!';
		}
?>