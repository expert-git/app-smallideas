<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	require_once("xpdo.class.php");
	
	include_once(EPABSPATH."/include/classes/BO/userHidden.class.php");
	include_once(EPABSPATH."/include/classes/BO/voucher.class.php");
	
	class DAL_UserHidden {


		/*	 	 
		 * Get all 
		 */
		static public function GetAllForUser($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT v.* FROM `userHidden` u LEFT JOIN `voucher` v ON u.voucherId = v.id WHERE userId = :id 
								ORDER BY u.dateAdded DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				//print_r($sth->errorInfo());
				
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_Voucher($aResult);
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
		 * Get specific item - used to check if voucher already used this year
		 */
		static public function GetByUserAndVoucher($userId,$voucherId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userHidden` 
								WHERE userId = :userId
								AND voucherId = :voucherId								
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':userId' => $userId,
					':voucherId' => $voucherId
					));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					

				if($sth->rowCount()>0) return new BO_UserHidden($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	



		/*	 	 
		 * Insert New 
		 */
		static public function Create($userId,$voucherId) {
			try
			{	
			
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `userHidden` (userId,voucherId) VALUES (:userId,:voucherId)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(										
					':userId' => $userId,
					':voucherId' => $voucherId				
				));
			//	print_r($sth->errorInfo());
				return true;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		

		/*	 	 
		 * Delete 
		 */
		static public function Delete($userId,$voucherId) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `userHidden`							
								WHERE userId = :userId AND voucherId = :voucherId LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':userId' => $userId,':voucherId'=>$voucherId));				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				//print_r($sth->errorInfo());
				if($sth->rowCount()>0) return $userId;
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		


		
		
	}


?>