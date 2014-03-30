<?php 
class User{
 
	private $db;
 
	public function __construct($database) {
	    $this->db = $database;
	}
	 public function duplicate_uname($username, $fbId) {
		$query = $this->db->prepare("SELECT COUNT(uid) FROM user WHERE name= ?");
		$query->bindValue(1, $username);
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			if($rows >= 1){
				return true;
			}else{
				if($fbId != NULL){
					$query = $this->db->prepare("SELECT COUNT(*) FROM user WHERE fbId= ?");
					$query->bindValue(1, $fbId);
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
				}else{
					return false;
				}
			}
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function register($username, $password, $email, $dob, $phone, $mphone, $pDesc, $referLink, $fbId){
		$password   = sha1($password);
		$query 	= $this->db->prepare("INSERT INTO user (name,password,email,dateOfBirth,phone,mobilePhone,personalDesc,referLink, fbId) VALUES (?,?,?,?,?,?,?,?,?)");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $dob);
		$query->bindValue(5, $phone);
		$query->bindValue(6, $mphone);
		$query->bindValue(7, $pDesc);
		$query->bindValue(8, hash("sha256", $username));
		if($fbId != NULL){
			$query->bindValue(9, $fbId);
		}else{
			$query->bindValue(9, NULL);
		}

		try{
			$query->execute();
			if($referLink != NULL){
				//Insert referring action
				$query = $this->db->prepare("SELECT uid FROM user WHERE name = ?");
				$query->bindValue(1, $username);
	    		$query->execute();
				$data = $query->fetch();
				$uid = $data['uid'];

				$query = $this->db->prepare("SELECT uid FROM user WHERE referLink = ?");
				$query->bindValue(1, $referLink);
	    		$query->execute();
				$data = $query->fetch();
				$referreruid = $data['uid'];

				$this->referralBonus($uid, 1);
				$this->referralBonus($referreruid, 1);
			}
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
    	$query = $this->db->prepare("SELECT `name` FROM `user` WHERE `referLink` = ?");
		$query->bindValue(1, $link);
		try{
			$query->execute();
			$data = $query->fetch();
			return $data;
	 
		}catch(PDOException $e){
			return "";
		}
    }

    function referralBonus($uid, $money){
    	try{
    		$this->db->beginTransaction();

    		$query = $this->db->prepare("SELECT money FROM user WHERE uid = ? FOR UPDATE");
    		$query->bindValue(1, $uid);
    		$query->execute();
			$data = $query->fetch();
			$money += $data['money'];

			$query = $this->db->prepare("UPDATE user SET money = ? WHERE uid = ? ");
    		$query->bindValue(1, $money);
    		$query->bindValue(2, $uid);
    		$query->execute();

    		$this->db->commit();
    		return true;
    	}catch(Exception $e){
    		$this->db->rollBack();
    		return false;
    	}
    }
}