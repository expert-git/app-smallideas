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
	include_once(EPABSPATH."/include/classes/BO/voucherLocation.class.php");
	
	class DAL_VoucherLocation {
			
		/*	 	 
		 * Delete all based on id
		 */
		static public function DeleteAllForVoucherId($voucherId) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `voucherLocation`							
								WHERE voucherId = :voucherId';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':voucherId' => $voucherId));				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);					
				//print_r($sth->errorInfo());
				return $sth->rowCount();
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}


		/*	 	 
		 * Insert New voucher location
		 */
		static public function Create($voucherLocationObj) {
			try
			{					
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `voucherLocation` (voucherId,address,lat,lng) 
								        VALUES (:voucherId,:address,:lat,:lng)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(											
					':voucherId' => $voucherLocationObj->voucherId,
					':address' => $voucherLocationObj->address,
					':lat' => $voucherLocationObj->lat,
					':lng' => $voucherLocationObj->lng
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
		 * Get all regions for voucher
		 */
		static public function GetAllForVoucherId($voucherId) {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `voucherLocation` WHERE voucherId = :voucherId';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':voucherId'=>$voucherId));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
					//print_r($rsResults);
					//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_VoucherLocation($aResult);
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
		 * Get all regions for voucher
		 */
		static public function GetAllActive() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT vl.* FROM `voucherLocation` vl LEFT JOIN `voucher` v ON vl.voucherId = v.id WHERE v.validFrom <= CURDATE() AND v.validTo >= CURDATE()';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
					//print_r($rsResults);
					//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_VoucherLocation($aResult);
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