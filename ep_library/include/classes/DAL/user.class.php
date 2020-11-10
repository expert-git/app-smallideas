<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
	
	require_once("xpdo.class.php");

	/**
	 * @TODO Update this reference if and when a common business object is created
	 */
	include_once(EPABSPATH."/include/classes/BO/user.class.php");
	
	class DAL_User {
		


		/*	 	 
		 * Get all user accounts
		 */
		static public function GetAll() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u ORDER BY registeredDatetime DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		
		
		/*	 	 
		 * Get all regular 12month accounts that are expiring in 3 days.
		 */
		 static public function GetExpiringInDays($days = 3) {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u WHERE isTrialAccount = 0 AND isSubscription = 1 AND subscriptionMonths = 12 AND accountExpiry = DATE(DATE_ADD(NOW(),INTERVAL '.$days.' DAY))';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		



		/*	 	 
		 * Get all user active accounts
		 */
		static public function GetAllActive() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u WHERE accountExpiry > CURDATE() ORDER BY registeredDatetime DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}


		/*	 	 
		 * Get all user active accounts, order by last Renewed
		 */
		static public function GetAllActiveByLastRenewed() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u WHERE accountExpiry > CURDATE() ORDER BY lastRenewed DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		
		
		
		/*	 	 
		 * Get all user active accounts, order by last Renewed
		 */
		static public function GetAllRenewedSince() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u WHERE accountExpiry > DATE_ADD(CURDATE(), INTERVAL 8 MONTH) ORDER BY lastRenewed DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}




		/*	 	 
		 * Get all trial user accounts expiring today
		 */
		 static public function GetExpiringTrialAccounts() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT u.* FROM `user` u WHERE isTrialAccount = 1 AND accountExpiry = CURDATE()';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}



		/*	 	 
		 * Get user details based on user id
		 */
		static public function GetById($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `user` WHERE id = :Id LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':Id' => $id));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				if($sth->rowCount()>0) return new BO_User($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		
		/*	 	 
		 * Get user details based on user id
		 */
		static public function Exists($email) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `user` WHERE email = :email LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':email' => $email));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				if($sth->rowCount()>0) return true;
				return false;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
					
		
		/*	 	 
		 * set password
		 */
		static public function SetPassword($accountID, $password) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'UPDATE `user` SET `password` = :Password WHERE id = :Id';			
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':Password' => $password, ':Id' => $accountID));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);
				return true;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	
		

	
		/*	 	 
		 * Get by Email
		 */
		static public function GetByEmail($email) {
			try
			{	
				$oDbConnection = new DAL_PDO();		
				$sqlStatement = 'SELECT * FROM `user` WHERE email = :Email LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':Email' => $email));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);									
				if($sth->rowCount()>0) 
				{					
					$userObj = new BO_User($rsResults);					
					return $userObj;
				}
				
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	
		

			/*	 	 
		 * Delete report based on id
		 */
		static public function Delete($id) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `user`							
								WHERE id = :id LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id' => $id));				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0) return $id;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}

		

			/* 
		 * Update User account
		 */
		static public function Update($userObj) {

			$userObj->isSubscription = ($userObj->isSubscription) ? $userObj->isSubscription : 1;
			$userObj->subscriptionMonths = ($userObj->subscriptionMonths) ? $userObj->subscriptionMonths : 12;
			$userObj->userGroup = ($userObj->userGroup) ? $userObj->userGroup : null;
			if(!$userObj->lastRenewed)
				$userObj->lastRenewed = date('Y-m-d');

			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'UPDATE `user` SET					
					`email` = :email,					
					`state` = :state,	
					`userGroup` = :userGroup,										
					`password` = :password,										
					`passwordResetUrl` = :passwordResetUrl,
					`passwordResetExpiry` = :passwordResetExpiry,
					`accountExpiry` = :accountExpiry,
					`lastRenewed` = :lastRenewed,
					`isSubscription` = :isSubscription,
					`subscriptionMonths` = :subscriptionMonths,
					`isTrialAccount` = :isTrialAccount					
				 	WHERE id = :id
					LIMIT 1';			
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(				
					':id' => $userObj->id,							
					':email' => $userObj->email,										
					':state' => $userObj->state,
					':userGroup' => $userObj->userGroup,	
					':password' => $userObj->password,																			
					':passwordResetUrl' => $userObj->passwordResetUrl,
					':passwordResetExpiry' => $userObj->passwordResetExpiry,					
					':accountExpiry' => $userObj->accountExpiry,
					':lastRenewed' => $userObj->lastRenewed,
					':isSubscription' => $userObj->isSubscription,
					':subscriptionMonths' => $userObj->subscriptionMonths,
					':isTrialAccount' => $userObj->isTrialAccount			
				));
				//print_r($userObj);
				//print_r($sth->errorInfo());
				$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
				
				return $userObj->id;
				
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	


		/*	 	 
		 * Insert New user
		 */
		static public function Create($userObj) {
			try
			{	
				$userObj->isTrialAccount = ($userObj->isTrialAccount) ? 1 : 0;
				$userObj->isSubscription = ($userObj->isSubscription==0) ? 0 : 1;
				$userObj->accountExpiry = ($userObj->accountExpiry) ? $userObj->accountExpiry : null;
				$userObj->lastRenewed = ($userObj->lastRenewed) ? $userObj->lastRenewed : null;
				$userObj->trialFirstName = ($userObj->trialFirstName) ? $userObj->trialFirstName : null;
				$userObj->trialLastName = ($userObj->trialLastName) ? $userObj->trialLastName : null;
				$userObj->trialPhone = ($userObj->trialPhone) ? $userObj->trialPhone : null;
				$userObj->userGroup = ($userObj->userGroup) ? $userObj->userGroup : null;
				$userObj->subscriptionMonths = ($userObj->subscriptionMonths) ? $userObj->subscriptionMonths : 12;
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `user` (email,state,userGroup,password,salt,accountExpiry,lastRenewed,isTrialAccount,trialFirstName,trialLastName,trialPhone,isSubscription,subscriptionMonths) VALUES (:email,:state,:userGroup,:password,:salt,:accountExpiry,:lastRenewed,:isTrialAccount,:trialFirstName,:trialLastName,:trialPhone,:isSubscription,:subscriptionMonths)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':email' => $userObj->email,
					':state' => $userObj->state,	
					':userGroup' => $userObj->userGroup,	
					':password' => $userObj->password,
					':salt' => $userObj->salt,
					':accountExpiry' => $userObj->accountExpiry,
					':lastRenewed' => $userObj->lastRenewed,
					':isTrialAccount' => $userObj->isTrialAccount,					
					':trialFirstName' => $userObj->trialFirstName,
					':trialLastName' => $userObj->trialLastName,
					':trialPhone' => $userObj->trialPhone,
					':isSubscription' => $userObj->isSubscription,
					':subscriptionMonths' => $userObj->subscriptionMonths
				));
			//	print_r($sth->errorInfo());
				return $oDbConnection->lastInsertId();
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}



	
	
	
	
	/*	 	 
		 * Get by password reset url
		 */
		static public function GetByPasswordResetUrl($passwordResetUrl) {
			try
			{	
				$oDbConnection = new DAL_PDO();		
				$sqlStatement = 'SELECT * FROM `user` WHERE passwordResetUrl = :passwordResetUrl LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':passwordResetUrl' => $passwordResetUrl));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);		
											//echo $passwordResetUrl;exit;
				// print_r($sth->errorInfo());
				if($sth->rowCount()>0) 
				{					
					$userObj = new BO_User($rsResults);					
					return $userObj;
				}
				
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}

	
		
	}


?>