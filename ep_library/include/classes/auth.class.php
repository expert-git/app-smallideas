<?php 

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

include_once ('DAL/authToken.class.php');
include_once ('DAL/user.class.php');
include_once ('DAL/userEdition.class.php');
include_once ('service.class.php');
include_once ('template.class.php');
include_once (EPABSPATH.'/include/random-lib/random.php');


class X_Auth 
{
	
	static public function setupCookie($userId,$existingSelector = NULL){
		
		//after login
		$selector = ($existingSelector) ? $existingSelector : base64_encode(random_bytes(6).str_replace(" ","",$_SERVER['HTTP_USER_AGENT']));  //generate new selector
		$authenticator = random_bytes(33);
		$expiryepoch = time() + 5184000; //3 months
		
		$authTokenObj = new BO_AuthToken(
			array(
				'selector' => $selector,
				'token' => hash('sha256', $authenticator),
				'userId' => $userId,  
				'expires' => date('Y-m-d H:i:s', $expiryepoch)
			)
		);		
		
	    $cresult = setcookie(
	        'remember',
	         $selector.':'.base64_encode($authenticator),
	         $expiryepoch,  
	         '/',
	         COOKIEDOMAIN,
	         true, // TLS-only
	         true  // http-only
	    );
		
		//echo "\ncookie result: $cresult\n";
		//print_r($_COOKIE);
		
		//update cookie in DB
		$authTokenObj->save();
	
		
	}
	



	/**
	 * Handle Login & authentication
	 */
	static public function Login(){
				
		//process login request
		if(isset($_POST['username'])){
			$loginSuccess = (self::ProcessLogin($_POST['username'], $_POST['password']));
			//print_r($_SESSION);
			//exit;
			
			if($loginSuccess){
				//redirect normal users back to main menu
				if(strpos($_SERVER['SCRIPT_FILENAME'],'/manager/')!==false){
					
					self::setupCookie($_SESSION['userid']);
					header("Location: /manager/");
					exit;
					
				} else {
					//login to user app ok
					//check if has access to current edition
					//$userEditionObjArr = DAL_UserEdition::GetAllForUser($_SESSION['userid']);
					$userObj = DAL_User::GetById($_SESSION['userid']);
					//$yearNow = date('Y');
					$accessGranted = false;

					//print_r($userEditionObjArr); session_destroy(); exit;
					/*if($userEditionObjArr){
						foreach($userEditionObjArr as $userEditionObj){
							if($yearNow == $userEditionObj->edition)
								$accessGranted = true;
						}
					}*/

					if($userObj->accountExpiry >= date('Y-m-d')){
						$accessGranted = true;
					} 
					

					if($userObj->isTrialAccount && $userObj->accountExpiry <= date('Y-m-d')){
						//trial has expired						
						unset($_SESSION['username']);
						session_destroy();  //give error about EDITION below.
						$trialExpired = true;						
						
					} else if(!$accessGranted){						
						//user has correct login, but not for current edition
						unset($_SESSION['username']);
						unset($_SESSION['userid']);
						unset($_SESSION['usersession']);
						session_destroy();  //give error about EDITION below.
//				echo 'h';
						
					} else {
						
						self::setupCookie($_SESSION['userid']);											
						header("Location: /");
						exit;
						
					}
				}
			}
			
		}

		if(isset($_GET['logout'])){
			//echo 'saaa'; exit;
			self::logout();
		}
		
		

		//see if user authenticated to view page
		if(!self::isAuthenticated()){
			
			// if($_SERVER['REMOTE_ADDR'] == '1.136.106.225'){
// 				echo (self::isAuthenticated()) ? 'true' : 'false';
//
// 			}
			
			if(isset($accessGranted) && !$accessGranted){
				//echo 'ed'; 
				$success = EXPIRED;
				
			} else if(isset($trialExpired)){
				$success = TRIALEXPIRED;
			} else {
				//show login screen
				if(isset($loginSuccess)){
					if($loginSuccess){
						$success = YES;
					} else {
						$success = NO;
					}
				} else {
					$success = NOTSET;
				}
			}
			
			// if($_SERVER['REMOTE_ADDR'] == '1.136.106.225'){
	// 				//echo $success; exit;
	// 		}
			
			echo self::generateLoginBox($success);
			exit;
		}
		
		//print_r($_SESSION); exit;
		

	}
	

	/**
	 * Authenicate and login the user based on the username (email address) and password
	 * @param $usernameDirty
	 * @param $passwordDirty
	 */
	static public function ProcessLogin($usernameDirty, $passwordDirty)
	{						
		//clean inputs
		$username = Service::cleanEmail($usernameDirty);
		$password = Service::cleanPassword($passwordDirty);
		//echo $username;
		//get site's user/password details
		$userObj = DAL_User::GetByEmail($username);				
		
		// if($_SERVER['REMOTE_ADDR']=='1.128.105.40'){
// 			echo $username;
// 			echo self::getPasswordHash($userObj->salt,$password);
// 			print_r($userObj); exit;
// 		}

		//echo self::getPasswordHash($userObj->salt,$password); exit;
		//exit;
		if($userObj == null)
		{		
			// User was not found
			return false;
		}
		
		
		//ensure username + password are correct
		if(self::getPasswordHash($userObj->salt,$password) == $userObj->password)
		{
			//echo 'ddd'; exit;
			if($userObj->id > 0){
				//authenticated!
				$_SESSION['username'] = $username;
				$_SESSION['usersession'] = self::getSessionHash($userObj->id);  //generate sessionkey site session salt + username 	
				$_SESSION['userid'] = $userObj->id;
				if($userObj->isAdmin){
					$_SESSION['isAdmin'] = 1;
				} 

				return true;			
			}
		} 		

	//	echo 'ddd'; exit;
		
		return false;

	}
	

	/**
	 * Retrieve the hash of the user salt and password
	 * @param $salt
	 * @param $password
	 */
	static public function getPasswordHash($salt,$password)
	{
		return md5($salt.$password.$salt);
	}

	/**
	 * Retrieve the hash of the site session salt and username
	 * @param <1salt></1salt>
	 * @param $username
	 */
	static public function getSessionHash($username)
	{
		return md5(SESSION_SALT.$username);
	}
	
	/**
	 * Returns whether the current user has been authenticated by the system
	 */
	static public function isAuthenticated()
	{
	
		// session_destroy();
		// unset($_SESSION);
		//unset($_COOKIE['remember']);

//		if($_SERVER['REMOTE_ADDR'] == '1.136.106.225'){
			//print_r($_SESSION); exit;
//		}
		
		//pull details from Cookie if php session has ended
		if (empty($_SESSION['userid']) && !empty($_COOKIE['remember'])) {
		    list($selector, $cookietoken) = explode(':', $_COOKIE['remember']);

			$authTokenObj = DAL_AuthToken::GetBySelector($selector);

			// print_r($authTokenObj);
// 			echo "\n".$authTokenObj->token."\n";
// 			echo hash('sha256', base64_decode($cookietoken))."\n";
// 			print_r($_COOKIE['remember']);
						
		    if ($authTokenObj && strcmp($authTokenObj->token, hash('sha256', base64_decode($cookietoken))) == 0) {

				//match, so check that the user hasnt expired
				$userObj = DAL_User::GetById($authTokenObj->userId);
				if($userObj){
					if($userObj->accountExpiry >= date('Y-m-d')){
						
						//account not yet expired						
						//update session info				
				        $_SESSION['userid'] = $authTokenObj->userId;
						$_SESSION['usersession'] = self::getSessionHash($authTokenObj->userId); 
						$_SESSION['username'] = $userObj->email;
				
						//if manager re-fetch login details to verify
						if(strpos($_SERVER['SCRIPT_FILENAME'],'/manager/')!==false){
							$userObj = DAL_User::GetById($authTokenObj->userId);
							if($userObj->isAdmin){
								$_SESSION['isAdmin'] = 1;
							}
						}				
				 
				        // regenerate login token
						self::setupCookie($authTokenObj->userId,$authTokenObj->selector);
						//$_COOKIE['remember'] is only updated on the next load of the page
						
						
					}
				}
				
				
				

		    } else {
		    	//doesn't match, so delete cookie
			    $cresult = setcookie(   //time in the past
			        'remember',
			         '',
			         time() - 36000,  
			         '/',
			         COOKIEDOMAIN,
			         true, // TLS-only
			         true  // http-only
			    );		
				unset($_COOKIE['remember']);
				//remove from db if exists
				DAL_AuthToken::DeleteBySelector($selector);
		    }

		}
	


		//keep session active. Also session.gc_maxlifetime should be at least equal to the lifetime of this custom expiration 
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 604800)) {
		    // last request was more than 7 days ago
		    session_unset();     // unset $_SESSION variable for the run-time 
		    session_destroy();   // destroy session data in storage
		}
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

		if (!isset($_SESSION['CREATED'])) {
		    $_SESSION['CREATED'] = time();
		} else if (time() - $_SESSION['CREATED'] > 604800) {  // session started more than 7 days ago				    
		    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
		    $_SESSION['CREATED'] = time();  // update creation time
		}
		
		
		if(isset($_SESSION['usersession'])){
			if($_SESSION['usersession'] == self::getSessionHash($_SESSION['userid'])){
				return true;
			}
		}

		return false;
	}	
	
	/**
	 * 
	 * @param string $returnUrl
	 */
	static public function logout($returnUrl = "/"){
		//remove cookie
	    $cresult = setcookie(   //time in the past
	        'remember',
	         '',
	         time() - 36000,  
	         '/',
	         COOKIEDOMAIN,
	         true, // TLS-only
	         true  // http-only
	    );		
		unset($_COOKIE['remember']);
		//kill session
		session_destroy();
		session_unset();
		//redirect
		header("location:" . $returnUrl);
		exit;
	}

	/**
	 * Generates the login/logout box for the application which can be placed anywhere required
	 */
	static public function generateLoginBox($loginSuccess)
	{	
		//print_r($loginSuccess); exit;
		//print_r($_SESSION)	;
		if(strpos($_SERVER['SCRIPT_FILENAME'],'/manager/')!==false){
			//admin login
			$loginTemplate = new Template(EPABSPATH.'/templates/viewLoginAdmin.tmpl.php');
			
		} else {

			//normal user login
			$loginTemplate = new Template(EPABSPATH.'/templates/viewLogin.tmpl.php');

			//only allow login from phone/table
			include_once ('Mobile_Detect.php');
			$mobileDetect = new Mobile_Detect;				
			$loginTemplate->mobileDetect = $mobileDetect;

		}				
			
		$loginTemplate->loginSuccess = $loginSuccess;  //show error if previous login failure
		$loginTemplate->returnUrl = $_SERVER["REQUEST_URI"];
		//$loginTemplate->username = '';		
		return $loginTemplate->run();
	}






	/**
	 * Create a unique URL for resetting password, and email
	 * @param $email
	 */
	static public function sendPasswordResetLink($email)
	{
		//get user
		$email = Service::cleanEmail($email);
		$userObj = DAL_User::GetByEmail($email);
		//echo $email;
		//print_r($userObj);
		if($userObj){
			//generate unique string
			$randString = Service::generateRandomString();
			$passwordResetUrl = date('Ymdhis').$randString;

			//save to user 
			$userObj->passwordResetUrl = $passwordResetUrl;
			$userObj->passwordResetExpiry = date('Y-m-d',strtotime('+2 day'));
			$userObj->save();

			//prep email
			$emailContent = new Template(EPABSPATH.'/templates/emailResetPassword.tmpl.php');
			$emailContent->url = APPDOMAIN."/reset/{$passwordResetUrl}/";
			

			//send sendgrid (or smtp) email								
			$result = Service::sendMessage(array($email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,"Small Ideas login reset",$emailContent->run());
			//echo $result; exit;
			
		}

		return true;

	}




	/* 
	 * apply new password after resetting
	 */

	 public static function setPassword($passwordDirty,$urlDirty)
	 {

		 $password = Service::cleanPassword($passwordDirty);
		 $url = Service::cleanString($urlDirty);
//		 echo $urlDirty;
//		 echo $password; exit;
		 //check password meets requirements		 
		 if(!Service::checkPasswordRequirements($password)){
			 return false;
		 }
//		 echo 'ssss';
		 //ensure has access to unique url
		 $userObj = DAL_User::GetByPasswordResetUrl($url);
	//	 print_r($userObj); exit;
		 if(!$userObj)
		 	return false;

		$userObj->passwordResetUrl = "";
		$userObj->passwordResetExpiry = NULL;
		$userObj->password = self::getPasswordHash($userObj->salt,$password);
//		echo self::getPasswordHash($userObj->salt,$password); exit;
		$userObj->save();

		return true;

	 }
	 
	 
	 
	 


	 
}

?>