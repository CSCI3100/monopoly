<?php 
class User{
 
	private $db;
 
	public function __construct($database) {
	    $this->db = $database;
	}
	 public function duplicate_uname($username) {
		$query = $this->db->prepare("SELECT COUNT(uid) FROM user WHERE name= ?");
		$query->bindValue(1, $username);
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			if($rows >= 1){
				return true;
			}else{
				return false;
			}
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function register($username, $password){
		$password   = sha1($password);
		$query 	= $this->db->prepare("INSERT INTO user (name,password) VALUES (?,?)");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function login($username, $password){
		$query = $this->db->prepare("SELECT * FROM user WHERE name = ?");
		$query->bindValue(1, $username);
		try{
			
			$query->execute();
			$data = $query->fetch();
			$stored_password = $data['password'];
			$id = $data['uid'];
			
			#hashing the supplied password and comparing it with the stored hashed password.
			if($stored_password === sha1($password)){
				return $id;	
			}else{
				return false;	
			}
	 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function setplayerno($uid,$playerno){
		$query = $this->db->prepare("UPDATE user set playerno=? WHERE uid = ?");
		$query->bindValue(1, $playerno);
		$query->bindValue(2, $uid);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function userinfo($uid){
		$query = $this->db->prepare("SELECT * FROM user WHERE uid = ?");
		$query->bindValue(1, $uid);
		try{
			
			$query->execute();
			$data = $query->fetch();
			return $data;
	 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
}