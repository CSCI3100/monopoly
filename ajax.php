<?php

$func = $_POST['function'];

switch ($func) {
	case 'updateProfile':
		require './database.php';
		$uid = 				($_POST['uid']!=""?$_POST['uid']:NULL);
		$displayname = 		($_POST['displayName']!=""?$_POST['displayName']:NULL);
		$phone = 			($_POST['phone']!=""?$_POST['phone']:NULL);
		$mphone = 			($_POST['mobilePhone']!=""?$_POST['mobilePhone']:NULL);
		$personalDesc = 	($_POST['personalDesc']!=""?$_POST['personalDesc']:NULL);

		if(!($displayname or $phone or $mphone or $personalDesc)){
			echo "304"; // NOT MODIFIED
			break;
		}

		$sql = "UPDATE `user` SET ";
		if($displayname) $sql .= " `displayName` = :displayName,";
		if($phone) $sql .= " `phone` = :phone,";
		if($mphone) $sql .= " `mobilePhone` = :mobilePhone,";
		if($personalDesc) $sql .= " `personalDesc` = :personalDesc,";
		$sql .= "`uid` = :uid WHERE `uid` = :uid";
		$query = $db->prepare($sql);
		if($displayname) $query->bindValue(":displayName", $displayname);
		if($phone) $query->bindValue(":phone", $phone);
		if($mphone) $query->bindValue(":mobilePhone", $mphone);
		if($personalDesc) $query->bindValue(":personalDesc", $personalDesc);
		$query->bindValue(":uid", $uid);
		try {
			$query->execute();
			session_start();
			if($displayname) $_SESSION['dname'] = $displayname;
			echo "200"; // Success
		} catch (PDOException $e) {
			echo "500"; // DB Error
			break;
		}
		break;
	case 'changePasswd':
		require './database.php';
		$uid = 		$_POST['uid'];
		$pw1 = 		$_POST['pw1'];
		$pw2 = 		$_POST['pw2'];

		if($pw1 == "" or $pw2 == ""){
			echo "404"; // Empty
			break;
		}
		if($pw1 != $pw2){
			echo "401 "; // Not equal
			break;
		}

		$sql = "UPDATE `user` SET `password` = :password WHERE `uid` = :uid";
		$query = $db->prepare($sql);
		$query->bindValue(":uid", $uid);
		$query->bindValue(":password", sha1($pw1));
		try {
			$query->execute();
			echo "200"; // Success
		} catch (PDOException $e) {
			echo "500"; // DB Error
			break;
		}
		break;
	case 'getItem':
		session_start();
		require './database.php';
		require './class/user.php';
		$ui = new User($db);
		$uin = $ui->userinfo($_SESSION['uid']);
		echo json_encode(array('stop' => $uin['t1'], 'doub' => $uin['t2'], 'cash' => $uin['t3']));
		break;
	case 'sendMsg':
		session_start();
		require './database.php';
		require './class/user.php';
		$ui = new User($db);
		$from = $ui->userinfo($_SESSION['uid']);
		$u = $ui->userinfoByName($_POST['to']);
		if($u == NULL){
			echo "User not exist!";
			break;
		}
		if($u['uid']==$_SESSION['uid']){
			echo "Sorry, you can't send message to yourself.";
			break;
		}
		$query = $db->prepare("INSERT INTO `message` ( `senderId`, `receiverId`, `msg`, `read`, `timestamp`) VALUES (:senderId, :receiverId, :msg, false, CURRENT_TIMESTAMP)");
		$query->bindValue(":senderId", $_SESSION['uid']);
		$query->bindValue(":receiverId", $u['uid']);
		$query->bindValue(":msg", $_POST['msg']);
		try{
			$query->execute();
			echo "Message sent!";
		}catch(PDOException $e){
			echo "Sent Error";
			echo $e->getMessage();
		}
		break;
	case 'readMsg':
		session_start();
		require './database.php';
		$query = $db->prepare("SELECT id, f.name AS sender, msg, m.read r, timestamp FROM `message` m, `user` f, `user` t WHERE m.receiverId = t.uid AND t.uid = :uid AND f.uid = m.senderId ORDER BY `timestamp` DESC");
		$query->bindValue(":uid",$_SESSION['uid']);
		try{
			$query->execute();
			echo json_encode($query->fetchAll());
		}catch(PDOException $e){
			die($e->getMessage());
		}
		break;
	case 'showMsg':
		require './database.php';
		$query = $db->prepare("SELECT id, f.name AS sender, msg, m.read r, timestamp FROM `message` m, `user` f WHERE m.id = :id AND f.uid = m.senderId");
		$query->bindValue(":id", $_POST['id']);
		
		try{
			$query->execute();
			echo json_encode($query->fetch());
			$query2 = $db->prepare("UPDATE  `message` SET  `read` =  '1' WHERE  `message`.`id` = :id LIMIT 1");
			$query2->bindValue(":id", $_POST['id']);
			$query2->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		break;
	default:
		echo "No function";
		break;
}

?>