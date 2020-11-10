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
	include_once(EPABSPATH."/include/classes/BO/authToken.class.php");
	
	class DAL_AuthToken {
		


		/*	 	 
		 * Get user details based on user id
		 */
		static public function GetBySelector($selector) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `authToken` WHERE selector = :selector LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':selector' => $selector));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				if($sth->rowCount()>0) return new BO_User($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		
		/*	 	 
		 * Delete by the selector
		 */
		static public function DeleteBySelector($selector) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `authToken`							
								WHERE selector = :selector';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':selector'=>$selector));				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0) return true;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		
		

		/*	 	 
		 * Delete report based on id
		 */
		static public function DeleteExpired() {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `authToken`							
								WHERE expires < NOW()';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0) return true;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}

		

		/* 
		 * Insert / Update cookie auth token
		 */
		static public function Update($authTokenObj) {


			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `authToken` SET					
					`selector` = :selector,					
					`token` = :token,					
					`userId` = :userId,
					`expires` = :expires				
				 	ON DUPLICATE KEY UPDATE 
					`token` = :token,					
					`userId` = :userId,
					`expires` = :expires
					';			
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(				
					':selector' => $authTokenObj->selector,							
					':token' => $authTokenObj->token,					
					':userId' => $authTokenObj->userId,
					':expires' => $authTokenObj->expires			
				));
				//print_r($userObj);
			//	print_r($sth->errorInfo());
				$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
				
				return $authTokenObj->userId;
				
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	


	 	 
	


	
	
	
		
	}


?>