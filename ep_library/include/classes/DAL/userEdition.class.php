<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	require_once("xpdo.class.php");
	
	include_once(EPABSPATH."/include/classes/BO/userEdition.class.php");
	
	class DAL_UserEdition {


		/*	 	 
		 * Get all 
		 */
		static public function GetAllForUser($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userEdition` WHERE userId = :id
								ORDER BY edition ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserEdition($aResult);
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
		 * Get all 
		 */
		static public function GetForUserYear($id,$year) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userEdition` WHERE userId = :id AND edition = :year LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id,':year'=>$year));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);
				if($sth->rowCount()>0) return new BO_UserEdition($rsResults);							
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}


		/*	 	 
		 * Delete editions for a user
		 */
		static public function DeleteAllForUser($userId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE FROM `userEdition` WHERE userId = :userId';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':userId' => $userId));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);									
				return $sth->rowCount();
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}



		/*	 	 
		 * Insert New user edition
		 */
		static public function Create($userEditionObj) {
			try
			{	
			
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `userEdition` (userId,edition) VALUES (:userId,:edition)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(					
					':userId' => $userEditionObj->userId,
					':edition' => $userEditionObj->edition
				));
			//	print_r($sth->errorInfo());
				return $oDbConnection->lastInsertId();
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}














		
		
	}


?>