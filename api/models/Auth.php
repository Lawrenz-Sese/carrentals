<?php
header("Access-Control-Allow-Origin: *");
	class Auth {
		protected $gm;


		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->pdo = $pdo;
		}
		

        ########################################
		# 	USER AUTHENTICATION RELATED METHODS
		########################################
		public function encrypt_password($pword) {
			$hashFormat="$2y$10$";
		    $saltLength=22;
		    $salt=$this->generate_salt($saltLength);
		    return crypt($pword,$hashFormat.$salt);
		}


        protected function generate_salt($len) {
			$urs=md5(uniqid(mt_rand(), true));
	    $b64String=base64_encode($urs);
	    $mb64String=str_replace('+','.', $b64String);
	    return substr($mb64String,0,$len);
		}

        public function pword_check($pword, $existingHash) {
			$hash=crypt($pword, $existingHash);
			if($hash===$existingHash){
				return true;
			}
			return false;
		}

		public function regUser($dt){
			$payload = "";
			$remarks = "";
			$message = "";
            $payload = $dt;
            $encryptedPassword = $this->encrypt_password($dt->user_password);

            $payload = array(
                'user_email'=>$dt->user_email,
                'user_password'=>$this->encrypt_password($dt->user_password)
            );

            $sql = "INSERT INTO tbl_users(user_fname, user_mname, user_lname, user_contact,user_address,user_email, user_username,user_password, user_verification) 
                           VALUES ('$dt->user_fname','$dt->user_mname','$dt->user_lname','$dt->user_contact','$dt->user_address','$dt->user_email', '$dt->user_username', '$encryptedPassword', '$dt->user_verification')";
                     

                           $data = array(); $code = 0; $errmsg= ""; $remarks = "";
                           try {
                       
                               if ($res = $this->pdo->query($sql)->fetchAll()) {
                                   foreach ($res as $rec) { array_push($data, $rec);}
                                   $res = null; 
								   $code = 200; $message = "Successfully Registered"; $remarks = "success";
                                   return array("code"=>200, "remarks"=>"success");
                               }
                           } catch (\PDOException $e) {
                               $errmsg = $e->getMessage();
                               $code = 403;
                           }
						   return $this->gm->sendPayload($payload, $remarks, $message, $code);                
        }

		public function changePasswordFp($dt){
			$payload = "";
			$remarks = "";
			$message = "";
            $payload = $dt;
            $encryptedPassword = $this->encrypt_password($dt->user_password);


            $sql = "UPDATE tbl_users SET user_password = '$encryptedPassword' WHERE user_id ='$dt->user_id'";
                     

                           $data = array(); $code = 0; $errmsg= ""; $remarks = "";
                           try {
                       
                               if ($res = $this->pdo->query($sql)) {
                                   foreach ($res as $rec) { array_push($data, $rec);}
                                   $res = null; 
								   $code = 200; 
								   $message = "Successfully Registered"; 
								   $remarks = "success";
								   $payload = null;
                               }
                           } catch (\PDOException $e) {
                               $errmsg = $e->getMessage();
                               $code = 403;
                           }
						   return $this->gm->sendPayload($payload, $remarks, $message, $code);                
        }






		public function loginUser($dt){
			$payload = $dt;
			$user_email = $dt->user_email;
			$user_password = $dt->user_password;
			$payload = "";
			$remarks = "";
			$message = "";
			$code = 0;

			$sql = "SELECT * FROM tbl_users WHERE user_email='$user_email' LIMIT 1";
			$res = $this->gm->generalQuery($sql, "Incorrect username or password");
			if($res['code'] == 200) {
				if($this->pword_check($user_password, $res['data'][0]['user_password'])) {
					
					$user_fname = $res['data'][0]['user_fname'];
					$user_lname = $res['data'][0]['user_lname'];
					$user_id = $res['data'][0]['user_id'];
					$isAdmin = $res['data'][0]['isAdmin'];
					$isActive = $res['data'][0]['isActive'];
		

					$code = 200;
					$remarks = "success";
					$message = "Logged in successfully";
					$payload = array("user_id"=>$user_id, "user_fname"=>$user_fname, "user_lname"=>$user_lname, "isAdmin"=>$isAdmin, "isActive"=>$isActive);
				} else {
					$payload = null; 
					$remarks = "failed"; 
					$message = "Incorrect username or password";
				}
			}	else {
				$payload = null; 
				$remarks = "failed"; 
				$message = $res['errmsg'];
			}
			return $this->gm->sendPayload($payload, $remarks, $message, $code);
		}

		


    }
    ?>