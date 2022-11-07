<?php
header("Access-Control-Allow-Origin: *");

// PHP MAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require '../api/vendor/autoload.php';



	class Auth {
		protected $gm;


		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->pdo = $pdo;
		}
		

        ########################################
		# 	USER AUTHENTICATION RELATED METHODS
		########################################
		public function encrypt_password($pword) 
		{
			$hashFormat="$2y$10$";
		    $saltLength=22;
		    $salt=$this->generate_salt($saltLength);
		    return crypt($pword,$hashFormat.$salt);
		}


        protected function generate_salt($len) 
		{
			$urs=md5(uniqid(mt_rand(), true));
			$b64String=base64_encode($urs);
			$mb64String=str_replace('+','.', $b64String);
			return substr($mb64String,0,$len);
		}

        public function pword_check($pword, $existingHash) 
		{
			$hash=crypt($pword, $existingHash);

			if($hash===$existingHash)
			{
				return true;
			}

			return false;
		}


		public function check_email_availability($email)
		{
			$sql = "SELECT * FROM tbl_user WHERE user_email = '$email'";

			$response = $this->pdo->query($sql)->fetchAll() ? true : false;

			return $response;

			
		}

		public function register_user($dt)
		{
	
			$payload = "";
			$remarks = "";
			$message = "";
            $payload = $dt;

			
			if($this->check_email_availability($dt->user_email))
			{
				$remarks = "error";
				$message = "Email Already Exist";
				$code = 200;
				return $this->gm->sendPayload($payload, $remarks, $message, $code);
			}

            $encryptedPassword = $this->encrypt_password($dt->user_password);

            $payload = array(
								'user_email'=>$dt->user_email,
								'user_password'=>$this->encrypt_password($dt->user_password)
            				);

            $sql = "INSERT INTO tbl_user
								(
								 user_fname, 
								 user_mname, 
								 user_lname, 
								 user_contact,
								 user_address, 
								 user_email,
								 user_password,
								 user_type,
								 rider_license,
								 rider_registration
								 ) 
                    
						VALUES (
								'$dt->user_fname',
								'$dt->user_mname',
								'$dt->user_lname',
								'$dt->user_contact',
								'$dt->user_address',
								'$dt->user_email',
								'$encryptedPassword',
								'$dt->user_type',
								'$dt->rider_license',
								'$dt->rider_registration'
								)";
                     
			$data = array(); $code = 0; $errmsg= ""; $remarks = "";
			
			try {
		
				if ($res = $this->pdo->query($sql)) 
				{
					
					foreach ($res as $rec) { array_push($data, $rec);}
					$res = null; 
					$code = 200; $message = "Successfully Registered"; $remarks = "success";

				}


				} 

			catch (\PDOException $e) 
				{
					$errmsg = $e->getMessage();
					$code = 403;
				}

			return $this->gm->sendPayload($payload, $remarks, $message, $code);                
        }


		public function send_otp($dt)
		{
			$otp = substr(bin2hex(random_bytes(6)),0, 6);
			$payload = null;

			$sql = "INSERT INTO tbl_userverification
								(
									user_email,
									user_otp
								)
						VALUES (
									'$dt->user_email',
									'$otp'
							   )";

			if(!$res = $this->pdo->query($sql))
			{
				
				$remarks = "error";
				$message = "Something Went Wrong!";
				$code = 200;
				return $this->gm->sendPayload($payload, $remarks, $message, $code);

			}

			$receiver = $dt->user_email;
			$subj = 'CAR RENTAL ACCOUNT - OTP';
			$content = "HERE IS YOUR OTP $otp";

			$mail = new PHPMailer(true);

			try {
					//Server settings
					// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
					$mail->isSMTP();                                             //Send using SMTP
					$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
					$mail->Username   = 'chrisjohn.ifl@gmail.com';                  //SMTP username
					$mail->Password   = 'nrogvyyzestasaas';                               //SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

					//Recipients
					$mail->setFrom('carrental.capstone@gmail.com', 'CAR RENTAL');
					$mail->addAddress($receiver);     //Add a recipient
					$mail->addReplyTo('carrental.capstone@gmail.com', 'CAR RENTAL');

					//Content
					$mail->isHTML(true);                                  //Set email format to HTML
					$mail->Subject = $subj ;
					$mail->Body    = $content;
					$mail->AltBody =  $content;

					if($mail->send())
					{
						$remarks = "success";
						$message = "Sucessfully Registered!";
						$text 	 = "Check your registered email for the OTP.";
						$code = 200;

						
						return array("remarks" => $remarks, "message" => $message, "text" => $text, "code" => $code);
						// return $this->gm->sendPayload($payload, $remarks, $message, $code);
					}

					


				} 
				catch(Exception $e) 
				{

					return array("error"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
				}
		}


		public function check_user_is_verified($email)
		{
			$sql = "SELECT isVerified FROM tbl_user WHERE user_email = '$email'";
			$isVerified = $this->pdo->query($sql)->fetchAll();
			

			if($isVerified[0]['isVerified'] == 0)
			{
				$response = 'not verified';
			}

			else if($isVerified[0]['isVerified'] == 1)
			{
				$response = 'verified';
			}

			else
			{
				$response = "user don't exist";
			}

			return $reponse;

		}



	
		public function login_user($d)
		{
			$payload = $d;
			$user_email = $d->user_email;
			$user_password = $d->user_password;
			$code = 404;
			$icon = 'error';
			$text = "Wrong Password or Email";
			$title = 'Wrong Credentials';

			$sql = "SELECT * FROM tbl_user WHERE user_email='$user_email' LIMIT 1";
			$res = $this->gm->generalQuery($sql, "Incorrect username or password");
			if($res['code'] == 200) {
				if($this->pword_check($user_password, $res['data'][0]['user_password'])) {
					$user_payload = new StdClass;
					$user_payload->user_email = $res['data'][0]['user_email'];
					$user_payload->user_fname = $res['data'][0]['user_fname'];
					$user_payload->user_mname = $res['data'][0]['user_mname'];
					$user_payload->user_lname = $res['data'][0]['user_lname'];
					$user_payload->user_address = $res['data'][0]['user_address'];
					$user_payload->user_id = $res['data'][0]['user_id'];
					$user_payload->user_type = $res['data'][0]['user_type'];
					$user_payload->isVerified = $res['data'][0]['isVerified'];
					$user_payload->userAddedDate = $res['data'][0]['userAddedDate'];
					$user_payload->user_contact = $res['data'][0]['user_contact'];
					
				
					if($res['data'][0]['user_type'] == "rider")
					{
						$user_payload->riderLicense = $res['data'][0]['rider_license'];
						$user_payload->riderRegistration = $res['data'][0]['rider_registration'];
						$user_payload->isAllowedToBook = $res['data'][0]['isAllowedToBook'];
					}

		

					$code = 200;
					$icon = "success";
					$text = "Logged in successfully";
					
					$title = "Successfully Logged In";
						
					if($res['data'][0]['isVerified'] == 0)
					{
						$text = "not verified";

					}

				
				} else {
					$payload = null; 
					$icon = "error"; 
					$text = "Incorrect username or password";
				}
			}	else {
				$payload = null; 
				$icon = "error"; 
				$text = $res['errmsg'];
			}

			return array('code' => $code, 'icon' => $icon, 'text' => $text, 'title' => $title, 'payload' => $user_payload);


			
		}

		public function verify_user($d)
		{
			
			$sql = "SELECT * FROM tbl_userverification WHERE user_email = '$d->user_email' AND user_otp = '$d->user_otp'";
			$result = $this->gm->generalQuery($sql, "Incorrect username or password");
			$code = 404;
			$icon = 'error';
			$text = "You've entered the wrong OTP";
			$title = 'Wrong OTP';

			if($result["code"] == 200)
			{
				
				$verify_sql = "UPDATE `tbl_user` SET `isVerified` = 1 WHERE user_email = '$d->user_email'";
				$response = $this->gm->generalQuery($sql, "Incorrect username or password");

				$isVerified = $this->pdo->query($verify_sql);

				if(!$isVerified)
				{
					$title = 'Something went wrong!';
					$text = 'Please contact the administrator';
				}
				else
				{
					$code = 200;
					$icon = 'success';
					$title = 'User Verified';
					$text = 'Welcome to Car Rentals!';
				}

			}
	
			return array('code' => $code, 'icon' => $icon, 'text' => $text, 'title' => $title);

		}


		// public function changePasswordFp($dt){
		// 	$payload = "";
		// 	$remarks = "";
		// 	$message = "";
        //     $payload = $dt;
        //     $encryptedPassword = $this->encrypt_password($dt->user_password);


        //     $sql = "UPDATE tbl_users SET user_password = '$encryptedPassword' WHERE user_id ='$dt->user_id'";
                     

        //                    $data = array(); $code = 0; $errmsg= ""; $remarks = "";
        //                    try {
                       
        //                        if ($res = $this->pdo->query($sql)) {
        //                            foreach ($res as $rec) { array_push($data, $rec);}
        //                            $res = null; 
		// 						   $code = 200; 
		// 						   $message = "Successfully Registered"; 
		// 						   $remarks = "success";
		// 						   $payload = null;
        //                        }
        //                    } catch (\PDOException $e) {
        //                        $errmsg = $e->getMessage();
        //                        $code = 403;
        //                    }
		// 				   return $this->gm->sendPayload($payload, $remarks, $message, $code);                
        // }




    }
    ?>