<?php 


	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/


include_once ('DAL/user.class.php');
include_once ('DAL/userEdition.class.php');
include_once ('auth.class.php');

/**
 * 
 * 
 */
class X_User
{
	public static function emailExists($email){
		return DAL_User::Exists($email);
	}
	
	public static function deleteUser($id){
		return DAL_User::DeleteUser($id);
	}

	
	
	/* update user account */
	public static function Update($userArr){		

		//clean inputs
		$cleanArr = array();
		//print_r($userArr); exit;
		foreach($userArr as $key => $val){	
			switch($key){				
				case "email":
					$cleanArr[$key] = Service::cleanEmail($val);
					break;
				case "state":				
					$cleanArr[$key] = Service::cleanString($val);
					break;
				case "userId":
					$cleanArr[$key] = Service::cleanNumeric($val);
					break;
				case "accountExpiry":				
					$cleanArr[$key] = Service::cleanDate($val);
					break;
				case "isTrialAccount":
					$cleanArr[$key] = Service::cleanNumeric($val);
					break;
				default:
					$cleanArr[$key] = Service::cleanString($val);
			}				 				
		}

		//check password meets requirements		
		if(isset($cleanArr['password']) && $cleanArr['password']!='00000000'){
			if(!Service::checkPasswordRequirements($cleanArr['password'])){
				return PASSWORD;
			}
		}

		//userobj
		if(isset($cleanArr['userId'])){
			$userObj = DAL_User::GetById($cleanArr['userId']);
		} 

		//check if email address changed and if already exists by another account
		if(isset($userObj) && $userObj->email != $cleanArr['email']){
			$userObjFromEmail = DAL_User::GetByEmail($cleanArr['email']);
			if($userObjFromEmail){
				//found so cannot use
				return EMAIL;
			}
		}

		if(!(isset($userObj))){
			$userObj = new BO_User();
			//generate salt
			$userObj->salt = Service::generateRandomString(10);
		}

		//check if is a trial account
		if(isset($cleanArr['isTrialAccount']) && $cleanArr['isTrialAccount']){
			//only set if not previously set
			if(!(isset($userObj) && $userObj->accountExpiry)){
				$cleanArr['accountExpiry'] = date('Y-m-d',strtotime('+'.TRIAL_DAYS.' days'));
			}
		}
		
		//$editionObjArr = array();
		//print_r($cleanArr);

		//update userObj
		
		foreach($cleanArr as $key => $val){
			switch($key){
				case "state":
					if($val=='Playgroup NSW'){
						$userObj->userGroup = $val;
						$val = 'NSW';
					} else {
						$userObj->userGroup = null;
					}
					$userObj->{$key} = $val;
					break;
				case "email":				
					$userObj->{$key} = $val;
					break;
				case "isTrialAccount":
					$userObj->{$key} = ($val) ? 1 : 0;
					break;
				case "isSubscription":
					$userObj->{$key} = ($val) ? 1 : 0;
					break;
				case "subscriptionMonths":
				case "accountExpiry":
					$userObj->{$key} = $val;
					break;
				case "password":
					if($val!='00000000'){
						//password has been changed
						$userObj->password = X_Auth::getPasswordHash($userObj->salt,$val);
					}
					break;						
			}
			
			
		}
		
//		print_r($userObj);exit;

		//ensure last renewed is set to today if not already set
		if(!$userObj->lastRenewed)
			$userObj->lastRenewed = date('Y-m-d');

		//save
		$id = $userObj->save();

		if(!$id){
			return EMAIL;
		}


		//if new account
		if(!$userObj->id){
			$userObj->id = $id;
		}

		return true;

	}
	
	
	
	
	
	
	/* create trial account.  Call by form on website */
	public static function CreateTrial($email,$firstname,$lastname){		
		
		//check if email address changed and if already exists by another account	
		$userObjFromEmail = DAL_User::GetByEmail($email);
		if($userObjFromEmail){
			//found so cannot use
			return EMAIL;
		}
		
		//edition
		//$edition = date('Y');
		$userObj = new BO_User();
		$password = Service::generatePassword();
		
		$userObj->salt = Service::generateRandomString(10);
		$userObj->trialFirstName = $firstname;
		$userObj->trialLastName = $lastname;
		$userObj->email = $email;
		$userObj->isTrialAccount = 1;
		$userObj->accountExpiry = date('Y-m-d',strtotime('+'.TRIAL_DAYS.' days'));
		$userObj->lastRenewed = date('Y-m-d');
		$userObj->password = X_Auth::getPasswordHash($userObj->salt,$password);
		//$userObj->latestEdition = $edition;

		//save
		$id = $userObj->save();
		
		//print_r($userObj);

		if(!$id){
			return false;
		}

		/*//add edition
		$userEditionObj = new BO_UserEdition(array('userId'=>$id,'edition'=>$edition));
		$userEditionObj->save();*/
		
		/* send login details */
		Service::wpSendTrialLogin($email,$password);	

		return $id;

	}
	
	
	
	/* create trial account.  Call by form on website */
	public static function CreateGroupUser($postDirty){		
		
		//clean inputs
		$cleanArr = array();
		//print_r($userArr); exit;
		foreach($postDirty as $key => $val){	
			switch($key){				
				case "email":
					$cleanArr[$key] = Service::cleanEmail($val);
					break;
				case "phone":
					$cleanArr['trialPhone'] = Service::cleanString($val);
					break;
				case "firstName":
					$cleanArr['trialFirstName'] = Service::cleanString($val);
					break;
				case "lastName":
					$cleanArr['trialLastName'] = Service::cleanString($val);
					break;
				case "password":
					$cleanArr[$key] = Service::cleanPassword($val);
					break;
				case "group":				
					$cleanArr[$key] = Service::cleanString($val);
					break;				
			}				 				
		}
		
		//check if email address changed and if already exists by another account	
		$userObjFromEmail = DAL_User::GetByEmail($cleanArr['email']);
		if($userObjFromEmail){
			//found so cannot use
			return EMAIL;
		}
		
		
		//create object
		$userObj = new BO_User();
		
		//enter data
		$userObj->salt = Service::generateRandomString(10);
		$userObj->accountExpiry = '2020-06-30';
		$userObj->lastRenewed = date('Y-m-d');
		
		//update userObj
		foreach($cleanArr as $key => $val){
			switch($key){
				case "group":
					if($val=='Playgroup NSW'){
						$userObj->userGroup = $val;
						$val = 'NSW';
					}
					$userObj->state = $val;
					break;	
				case "password":
					$userObj->password = X_Auth::getPasswordHash($userObj->salt,$val);
					break;					
				default:
					$userObj->{$key} = $val;
					break;									
			}
			
			
		}
		

		//print_r($userObj); exit;

		//save
		$id = $userObj->save();

		if(!$id){
			return false;
		}
		
		/* send login details */
		Service::wpSendGroupWelcomeEmail($userObj->email,$userObj->userGroup);	

		return $id;

	}




	/* update existing user account.  Used by Wordpress if existing account found. */
	public static function AddToExistingWP($userObj,$expiryDate){
		
		/*$editionObjArr = array();

		//get existing editions
		$userEditionObjArr = DAL_UserEdition::GetAllForUser($userObj->id);

		//print_r($userEditionObjArr); echo 'aa'; exit;

		$editionObjArr[] = $edition;
		if($userEditionObjArr){
			foreach($userEditionObjArr as $userEditionObj){
				$editionObjArr[] = $userEditionObj->edition;
			}
		}

		//work out latest edition		
		if($editionObjArr){
			foreach($editionObjArr as $ed){
				if(!isset($latestEdition)){
					$latestEdition = $ed;
				} else {
					if($ed > $latestEdition){
						$latestEdition = $ed;
					}
				}
			}
		}

		if(isset($latestEdition))
			$userObj->latestEdition = $latestEdition;
		else 
			$userObj->latestEdition = null;

			
		
		//remove trial flag
		$userObj->isTrialAccount = 0;
		


		//save
		$id = $userObj->save();
		
		//add new edition
		$userEditionObj = new BO_UserEdition(array('userId'=>$userObj->id,'edition'=>$edition));
		$userEditionObj->save();
		
		//if September or later in the year and buying next year's edition, also include this year (may not be necessary for Trial accounts since current year will already be setup, but good for normal users)
		if(date('m')*1 >= 9 && $edition == date('Y')+1){
			$userEditionObj = new BO_UserEdition(array('userId'=>$userObj->id,'edition'=>date('Y')));  //will fail in mysql if already there..
			$userEditionObj->save();
		} 

		return true; */

	}






}

?>