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
	
	default:
		echo "No function";
		break;
}

?>