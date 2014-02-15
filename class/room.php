<?php
class Room{
	private $db;
 
	public function __construct($database) {
	    $this->db = $database;
	}
	public function getroomlist($page){
		$offset=($page-1)*4;
		$query = $this->db->prepare("SELECT * FROM room WHERE playercount>0 and playercount<4 ORDER BY rid DESC LIMIT ".$offset.",4");
		$deletedQuery = $this->db->prepare("DELETE FROM room WHERE playercount=0");
		try{
			$query->execute();
			$deletedQuery->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
	public function createroom($roomname,$password){
		$password   = sha1($password);
		$query 	= $this->db->prepare("INSERT INTO room (name,password) VALUES (?,?)");
		$query->bindValue(1, $roomname);
		$query->bindValue(2, $password);
		try{
			$query->execute();
			return $this->db->lastInsertId(); 
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function getroomno(){
		$query = $this->db->prepare("SELECT COUNT(rid) FROM room WHERE playercount>0 and playercount<4");
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			return $rows;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function gettotalplayer($rid){
		$query = $this->db->prepare("SELECT playercount FROM room WHERE rid = ?");
		$query->bindValue(1, $rid);
		try{
			$query->execute();
			$data = $query->fetch();
			return $data['playercount'];
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function getroomname($rid){
		$query = $this->db->prepare("SELECT name FROM room WHERE rid = ?");
		$query->bindValue(1, $rid);
		try{
			$query->execute();
			$data = $query->fetch();
			return $data['name'];
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function addplayer($rid){
		$query = $this->db->prepare("UPDATE room set playercount=playercount+1 WHERE rid = ?");
		$query->bindValue(1, $rid);
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function leaveroom($rid){
		$query = $this->db->prepare("UPDATE room set playercount=playercount-1 WHERE rid = ?");
		$query->bindValue(1, $rid);
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
}
?>