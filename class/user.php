<?php 
class User{
 
	private $db;
 
	public function __construct($database) {
	    $this->db = $database;
	}
	public function t3($name){
	     $query = $this->db->prepare("UPDATE user SET t3 = t3 - 1 WHERE name = '".$name."'");
	     $query->execute();
	}
	public function t2($name){
		 $query = $this->db->prepare("UPDATE user SET t2 = t2 - 1 WHERE name = '".$name."'");
	     $query->execute();
	
	}
	public function t1($name){
		$query = $this->db->prepare("UPDATE user SET t1 = t1 - 1 WHERE name = '".$name."'");
	     $query->execute();
	
	}
	public function win($name){
		$query = $this->db->prepare("UPDATE user SET win = win + 1 WHERE name = '".$name."'");
		$query->execute();
	}
	public function lose($name){
		$query = $this->db->prepare("UPDATE user SET lose =lose + 1 WHERE name = '".$name."'");
		$query->execute();
	}
	public function buy($t1,$t2,$t3,$uid){
		$total=$t1*1+$t2*3+$t3*2;
		$query = $this->db->prepare("UPDATE user SET money = money-".$total.", t1 = t1+".$t1.", t2 = t2+".$t2.", t3 = t3 +".$t3." WHERE uid = ".$uid);
		$query->execute();
	}
	public function upmoney($uid, $money){
		$query = $this->db->prepare("UPDATE user SET money = money+".$money." WHERE uid = ".$uid);
		$query->execute();
	}
	public function duplicate_uname($username, $fbId, $displayname) {
		$sql = "SELECT COUNT(*) FROM user WHERE name= :name";
		if($fbId != NULL) $sql .= " OR fbId= :fbId";
		if($displayname != NULL) $sql .= " OR displayName= :displayName";

		$query = $this->db->prepare($sql);
		$query->bindValue(":name", $username);
		if($fbId != NULL){
			$query->bindValue(":fbId", $fbId);
		}
		if($displayname != NULL) {
			$query->bindValue(":displayName", $displayname);
		}

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
	public function register($username, $password, $email, $dob, $phone, $mphone, $pDesc, $referLink, $fbId, $displayname, $aid){
		$password   = sha1($password);
		$query 	= $this->db->prepare("INSERT INTO user (name,password,email,dateOfBirth,phone,mobilePhone,personalDesc,referLink, fbId, displayName) VALUES (:name,:password,:email,:dateOfBirth,:phone,:mobilePhone,:personalDesc,:referLink, :fbId, :displayName)");
		$query->bindValue(":name", $username);
		$query->bindValue(":password", $password);
		$query->bindValue(":email", $email);
		$query->bindValue(":dateOfBirth", $dob);
		$query->bindValue(":phone", $phone);
		$query->bindValue(":mobilePhone", $mphone);
		$query->bindValue(":personalDesc", $pDesc);
		$query->bindValue(":referLink", hash("sha256", $username));
		$query->bindValue(":displayName", $displayname);
		if($fbId != NULL){
			$query->bindValue(":fbId", $fbId);
		}else{
			$query->bindValue(":fbId", NULL);
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
			$query 	= $this->db->prepare("DELETE FROM `authentication` WHERE `aid` = ?");
			$query->bindValue(1, $aid);
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			return false;
		}
		return true;
	}

	public function postRegister($aid, $password){
		$query 	= $this->db->prepare("SELECT * FROM `authentication` WHERE `aid` = ?");
		$query->bindValue(1, $aid);
		try{
			$query->execute();
			if($query->rowCount() > 0){
				$data = $query->fetch();
				if($this->register(
					$data['name'], 
					$password, 
					$data['email'], 
					$data['dateOfBirth'], 
					$data['phone'], 
					$data['mobilePhone'], 
					$data['personalDesc'], 
					$data['referLink'], 
					$data['fbId'], 
					$data['displayName'],
					$aid)){
					if($data['fbId']!=""){
						require 'facebook-sdk/src/facebook.php';
						$config = array(
						    'appId' => '303832676434874',
						    'secret' => '297e537374bdeb5e50aeb51b21a36341',
						    'fileUpload' => false, // optional
						    'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
						);
						$facebook = new Facebook($config);
						$user = $facebook->getUser();
						$user_pic = $facebook->api(
					        "/me/picture",
					        "GET",
					        array (
					            'redirect' => false,
					            'height' => '640',
					            'type' => 'normal',
					            'width' => '640',
					        )
					    );
					    $path = './data/'.$data['name'].'.png';
				        $ch = curl_init($user_pic['data']['url']);
				        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				        $data = curl_exec($ch);
				        curl_close($ch);
				        file_put_contents($path, $data);
					}
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
			return false;
		}
	}

	public function getPreData($aid){
		$query 	= $this->db->prepare("SELECT * FROM `authentication` WHERE `aid` = ?");
		$query->bindValue(1, $aid);
		try{
			$query->execute();
			if($query->rowCount() <= 0){
				return NULL;
			}else{
				return $query->fetch();
			}
		}catch(PDOException $e){
			die($e->getMessage());
			return NULL;
		}
	}

	public function preRegister($username, $email, $dob, $phone, $mphone, $pDesc, $referLink, $fbId, $displayname, $sendEmail){
		//$password   = sha1($password);
		$query 	= $this->db->prepare("SELECT * FROM authentication WHERE aid = ?");
		$query->bindValue(1, hash("sha256", $username));
		$query->execute();
		if($query->rowCount() > 0) return false;

		$query 	= $this->db->prepare("INSERT INTO authentication (name,email,dateOfBirth,phone,mobilePhone,personalDesc,aid, fbId, displayName, referLink) VALUES (:name,:email,:dateOfBirth,:phone,:mobilePhone,:personalDesc,:aid,:fbId, :displayName, :referLink)");
		$query->bindValue(":name", $username);
		$query->bindValue(":email", $email);
		$query->bindValue(":dateOfBirth", $dob);
		$query->bindValue(":phone", $phone);
		$query->bindValue(":mobilePhone", $mphone);
		$query->bindValue(":personalDesc", $pDesc);
		$query->bindValue(":aid", hash("sha256", $username));
		$query->bindValue(":displayName", $displayname);
		$query->bindValue(":referLink", $referLink);
		if($fbId != NULL){
			$query->bindValue(":fbId", $fbId);
		}else{
			$query->bindValue(":fbId", NULL);
		}

		try{
			$query->execute();
			$from = "Do Not Reply";
			$fromemail = "do-not-reply@b5.hk";

			$subject = "Wealthy Family Monopoly - Confirmation of registration";

			$body = "Wealthy Family Monopoly - Confirm your account!\n\nDear $displayname,\n\n";
			$body .= "Thanks for playing Wealthy Family Monopoly. Please click the following link to activate your account and setup password.\n\n";
			$body .= "http://".$_SERVER['SERVER_NAME']."/mono/register.php?authentication=".hash("sha256", $username)."\n\n";
			$body .= "\n\nRegards,\nTeam Monopoly\nCUHK";

			// send code, do not edit unless you know what your doing
			$header = "Reply-To: Administrator <admin@b5.hk>\r\n"; 
		    $header .= "Return-Path: Administrator <admin@b5.hk>\r\n"; 
		    $header .= "From: $from <$fromemail>\r\n"; 
		    $header .= "Organization: Team Monopoly\r\n"; 
		    $header .= "Content-Type: text/plain\r\n"; 

		    if($sendEmail) mail("$email", "$subject", "$body", $header);
		    return true;
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
			if($query->rowCount() <= 0){
				return NULL;
			}
			$data = $query->fetch();
			return $data;
	 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function userinfoByName($name){
		$query = $this->db->prepare("SELECT * FROM user WHERE name = ?");
		$query->bindValue(1, $name);
		try{
			
			$query->execute();
			if($query->rowCount() <= 0){
				return NULL;
			}
			$data = $query->fetch();
			return $data;
	 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function forceSetUserAttr($attr, $val, $uid){
		$query = $this->db->prepare("UPDATE user SET `".$attr."` = :val WHERE `uid` = :uid");
		$query->bindValue(":val", $val);
		$query->bindValue(":uid", $uid);
		try{
			$query->execute();
			return $true;
	 
		}catch(PDOException $e){
			die("FSUA: ".$e->getMessage());
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
            	$path = (file_exists('../data/'.$one['name'].'.png')?'../data/'.$one['name'].'.png':'../data/default.png');
                $toBeReturn .= '<li><img src="'.$path.'"/><br />'.$one['displayName'].'<br /><a href="member.php?action=delete&uid='.$one['uid'].'"><button class="remove">Remove</button></a></li>';
            }
            return $toBeReturn;

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function delete_user($uid){
    	$deletedQuery = $this->db->prepare("DELETE FROM user WHERE uid=?");
    	$deletedQuery->bindValue(1, $uid);
        try{
            $deletedQuery->execute();
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