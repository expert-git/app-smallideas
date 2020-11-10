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
	include_once(EPABSPATH."/include/classes/BO/voucher.class.php");
	
	class DAL_VoucherPdf {

		/*	 	 
		 * Get user details based on user id
		 */
		static public function GetById($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT vp.* FROM `voucherPdf` vp WHERE vp.id = :id ORDER BY vp.id LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id' => $id));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);	
								
				if($sth->rowCount()>0) return new BO_Voucher($rsResults);
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}			


		/*	 	 
		 * Get all vouchers
		 */
		static public function GetAll($state = NULL) {
			
			$where = ($state) ? "WHERE state = '{$state}'" : '';
//			echo $where; exit;			
			
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();		
				
				$sqlStatement = 'SELECT vp.*, v.businessName, v.title FROM `voucherPdf` vp LEFT JOIN `voucher` v ON vp.voucherId = v.id ORDER BY vp.id ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
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
		 * Delete report based on id
		 */
		static public function Delete($id) {
			try
			{					
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `voucherPdf`							
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
	 * Update
	*/
	static public function Update($voucherObj){
		
		try
		{		
			$oDbConnection = new DAL_PDO();			
			$sqlStatement = 'UPDATE `voucherPdf` SET					
				`voucherId`= :voucherId,					
				`fileName`= :fileName,					
				`status` = :status
			 	WHERE id = :id
				LIMIT 1';			
			$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
			$sth->execute(array(				
				':id' => $voucherObj['voucherPdfId'],							
				':voucherId'=> $voucherObj['voucherId'],					
				':fileName'=> $voucherObj['fileName'],					
				':status' => $voucherObj['status']				
			));	
			$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
			
			return $voucherObj['voucherPdfId'];
			
		}
		catch (Exception $ex)
		{			
			throw $ex;	
		}
	}	
	
	static public function statusUpdate($voucherObj){
		
		try
		{		
			$oDbConnection = new DAL_PDO();			
			$sqlStatement = 'UPDATE `voucherPdf` SET
				`status` = :status
			 	WHERE id = :id
				LIMIT 1';			
			$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
			$sth->execute(array(				
				':id' => $voucherObj['id'],					
				':status' => $voucherObj['status']				
			));	
			$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
			
			return $voucherObj['id'];
			
		}
		catch (Exception $ex)
		{			
			throw $ex;	
		}
	}


	/*	 	 
	 * Insert 
	 */
	static public function Create($voucherObj) {
		if(!$voucherObj['status']){
			$voucherObj['status'] = 0;
		}
		
		try
		{				
								
			$oDbConnection = new DAL_PDO();			
			$sqlStatement = 'INSERT INTO `voucherPdf` (voucherId,fileName,status) 
							        VALUES (:voucherId,:fileName,:status)';
			$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
			$sth->execute(array(											
				':voucherId'=> $voucherObj['voucherId'],					
				':fileName'=> $voucherObj['fileName'],					
				':status' => $voucherObj['status']
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