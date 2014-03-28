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
	public function register($username, $password, $email, $dob, $phone, $mphone, $pDesc, $referLink){
		$password   = sha1($password);
		$query 	= $this->db->prepare("INSERT INTO user (name,password,email,dateOfBirth,phone,mobilePhone,personalDesc,referLink) VALUES (?,?,?,?,?,?,?,?)");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $dob);
		$query->bindValue(5, $phone);
		$query->bindValue(6, $mphone);
		$query->bindValue(7, $pDesc);
		$query->bindValue(8, hash("sha256", $username));

		if($referLink != NULL){
			//Insert referring action
		}

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

    //below are admin function
    public function get_user_list(){
        $query = $this->db->prepare("SELECT * FROM user ORDER BY uid");
        try{
            $query->execute();
            $data = $query->fetchAll();
            $toBeReturn = "";
            foreach($data as $one){
                $toBeReturn .= '<li><img src="../data/'.$one['name'].'.png"><br />'.$one['name'].'<br /><button class="edit">Edit</li>';
            }
            return $toBeReturn;

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //Get referrer name
    function getReferrer($link){
    	$query = $this->db->prepare("SELECT name FROM user WHERE referLink = ?");
		$query->bindValue(1, $link);
		try{
			$query->execute();
			$data = $query->fetch();
			return $data;
	 
		}catch(PDOException $e){
			return "";
		}
    }
}