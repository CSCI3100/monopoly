<?php 
require './database.php';
require './class/user.php';
       session_start();
		$user=new User($db);
		$data = $user->userinfo($_SESSION['uid']);
	   	if($_POST['one']*1+$_POST['double']*3+$_POST['cash']*2<$data['money']){
        $user->buy($_POST['one'],$_POST['double'],$_POST['cash'],$_SESSION['uid']);
		header("Location: buytool.php?res=1");
			}else{
				header("Location: buytool.php?res=0");
				}
?>