<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	require_once("xpdo.class.php");
	include_once(EPABSPATH."/include/classes/BO/userHistory.class.php");
	
	class DAL_UserHistory {



		/*	 	 
		 * Get absolutely all 
		 */
		static public function GetAbsolutelyAllForUser($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userHistory`								
								WHERE userId = :id 
								ORDER BY dateRedeemed DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				//print_r($sth->errorInfo());				
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserHistory($aResult);
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
		static public function GetAllForUser($id,$sinceDate) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT uh.*,v.allowMonthlyUse FROM `userHistory` uh
								LEFT JOIN `voucher` v
								ON uh.voucherId = v.id
								WHERE userId = :id AND dateRedeemed >= :sinceDate 
								ORDER BY dateRedeemed DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id,':sinceDate'=>$sinceDate));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				//print_r($sth->errorInfo());				
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserHistory($aResult);
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
		 * Get all ORIG
		 *
		static public function GetAllForUser($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT uh.*,v.allowMonthlyUse FROM `userHistory` uh
								LEFT JOIN `voucher` v
								ON uh.voucherId = v.id
								WHERE userId = :id AND YEAR(dateRedeemed) = YEAR(CURDATE()) 
								ORDER BY dateRedeemed DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);			
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserHistory($aResult);
					}
					return $objArr;
				}								
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		} */

 

		/*	 	 
		 * Get specific item - used to check if voucher already used this month
		 */
		static public function GetByMonthlyRecurring($userId,$voucherId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userHistory` 
								WHERE userId = :userId
								AND isDeleted = 0
								AND voucherId = :voucherId
								AND YEAR(dateRedeemed) = YEAR(CURDATE())
								AND MONTH(dateRedeemed) = MONTH(CURDATE())
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':userId' => $userId,
					':voucherId' => $voucherId
					));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				// print_r($sth->errorInfo());
				// print_r($rsResults); exit;
				if($sth->rowCount()>0) return new BO_UserHistory($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}		


		/*	 	 
		 * Get specific item - used to check if voucher already used this month
		 */
		static public function GetByWeeklyRecurring($userId,$voucherId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `userHistory` 
								WHERE userId = :userId
								AND isDeleted = 0
								AND voucherId = :voucherId
								AND dateRedeemed >= SUBDATE(DATE(NOW()), INTERVAL 6 DAY)
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':userId' => $userId,
					':voucherId' => $voucherId
					));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				// print_r($sth->errorInfo());
				// print_r($rsResults); exit;
				if($sth->rowCount()>0) return new BO_UserHistory($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}		
		
		

		/*	 	 
		 * Get specific item - used to check if voucher already used this year
		 */
		static public function GetByUserAndVoucher($userId,$voucherId,$lastRenewedDate) {
			
			if($_SERVER['REMOTE_ADDR']=='1.152.106.55'){
//				echo $userId;
			}
			
			try
			{		
				$oDbConnection = new DAL_PDO();			
				// $sqlStatement = 'SELECT * FROM `userHistory`
// 								WHERE userId = :userId
// 								AND voucherId = :voucherId
// 								AND dateRedeemed >= :lastRenewedDate
// 								AND YEAR(dateRedeemed) = YEAR(CURDATE())
// 								LIMIT 1';
				$sqlStatement = 'SELECT * FROM `userHistory`
								WHERE userId = :userId
								AND isDeleted = 0
								AND voucherId = :voucherId
								AND dateRedeemed >= :lastRenewedDate								
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':userId' => $userId,
					':voucherId' => $voucherId,
					':lastRenewedDate' => $lastRenewedDate
					));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				if($sth->rowCount()>0) return new BO_UserHistory($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	



		/*	 	 
		 * Insert New 
		 */
		static public function Create($userHistoryObj) {
			try
			{	
			
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `userHistory` (dateRedeemed,userId,userGroup,voucherId,businessName,title) VALUES (:dateRedeemed,:userId,:userGroup,:voucherId,:businessName,:title)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(					
					':dateRedeemed' => $userHistoryObj->dateRedeemed,
					':userId' => $userHistoryObj->userId,
					':userGroup' => $userHistoryObj->userGroup,					
					':voucherId' => $userHistoryObj->voucherId,
					':businessName' => $userHistoryObj->businessName,
					':title' => $userHistoryObj->title					
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
		 * Update
		 */
		static public function Update($userHistoryObj) {
		
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'UPDATE `userHistory` SET					
					`isDeleted` = :isDeleted
				 	WHERE id = :id
					LIMIT 1';			
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(				
					':id' => $userHistoryObj->id,							
					':isDeleted' => $userHistoryObj->isDeleted							
				));				
			//	print_r($sth->errorInfo());
				$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
			
				return $userHistoryObj->id;
			
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}	
		
		
		
		
		
		/*	 	 
		 * Get all unique ids 
		 */
		static public function GetAllUnique() {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT voucherId,businessName,title FROM `userHistory` GROUP BY voucherId  ORDER BY businessName,voucherId'; // ORDER BY businessName
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				//print_r($sth->errorInfo());
//				print_r($rsResults); exit;				
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserHistory($aResult);
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
		 * Get stats
		 */
		static public function GetStats($year,$month,$voucher,$state) {
			
			$dbYear = ($year) ? " AND YEAR(dateRedeemed) = '{$year}'" : '';
			$dbMonth = ($month) ? " AND MONTH(dateRedeemed) = '{$month}'" : '';
			$dbVoucher = ($voucher) ? " AND v.voucherId = '{$voucher}'" : '';
//			echo $state; exit;
			if($state){
				//add exceptions to user groups, as they're not a true state.
				if($state=='NSW'){
					$state = " AND v.state = '{$state}' AND uh.userGroup IS NULL";
				} elseif($state=='Playgroup NSW'){
					$state = " AND v.state = 'NSW' AND uh.userGroup = 'Playgroup NSW'";
				} else {
					$state = " AND v.state = '{$state}'";
				}
				//echo $state;exit;
			} else {
				$state = "";
			}
			

			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT uh.voucherId,uh.businessName,uh.title,v.state FROM `userHistory` uh LEFT JOIN `voucher` v ON uh.voucherId = v.id WHERE 1 '.$dbYear.$dbMonth.$dbVoucher.$state.' ORDER BY businessName,voucherId'; // ORDER BY businessName
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$id));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//				echo $sqlStatement;
//				print_r($sth->errorInfo());
//				print_r($rsResults); exit;				
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_UserHistory($aResult);
					}
					return $objArr;
				}								
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		


		
		
	}


?>