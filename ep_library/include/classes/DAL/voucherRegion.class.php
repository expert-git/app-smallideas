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
	include_once(EPABSPATH."/include/classes/BO/voucherRegion.class.php");
	
	class DAL_VoucherRegion {
				

		/*	 	 
		 * Get all regions for voucher
		 */
		static public function GetAllForVoucherId($voucherId) {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT vr.*,r.name FROM `voucherRegion` vr LEFT JOIN `region` r ON vr.regionId = r.id WHERE voucherId = :voucherId';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':voucherId'=>$voucherId));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
					//print_r($rsResults);
					//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_VoucherRegion($aResult);
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
		 * Get all in a region 
		 */
		static public function GetAllForRegionId($regionId) {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `voucherRegion` WHERE regionId = :regionId';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':regionId'=>$regionId));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
					//print_r($rsResults);
					//print_r($sth->errorInfo());
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_VoucherRegion($aResult);
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
		 * Delete report based on id
		 */
		static public function DeleteAllForVoucherId($voucherId) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `voucherRegion`							
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
		 * Insert New voucher region
		 */
		static public function Create($voucherRegionObj) {
			try
			{					
									
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'INSERT INTO `voucherRegion` (voucherId,regionId) 
								        VALUES (:voucherId,:regionId)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(											
					':voucherId' => $voucherRegionObj->voucherId,
					':regionId' => $voucherRegionObj->regionId
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