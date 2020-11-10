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
	
	class DAL_Voucher {
		


		/*	 	 
		 * Get user details based on user id
		 */
		static public function GetById($id) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `voucher` WHERE id = :id LIMIT 1';
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

		static public function GetAblPdfByVId($id) {
			try
			{
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT id,fileName FROM `voucherPdf` WHERE voucherId = :id && status = :status ORDER BY id ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id' => $id, ':status' => 1));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				if($sth->rowCount()>0){
				foreach($rsResults as $aResult){
						$objArr[] = new BO_Voucher($aResult);
					}
				}
					return $objArr;
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
				$sqlStatement = 'SELECT v.* FROM `voucher` v '.$where.' ORDER BY businessName ASC';
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
		 * Get all vouchers by search  --- edition removed
		 */
		static public function GetAllSearch($search,$state = 'VIC') {

			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT v.* FROM `voucher` v WHERE validFrom <= CURDATE() AND validTo >= CURDATE() AND state = :state AND MATCH(businessName,title,address,description,businessDescription) AGAINST (:search IN BOOLEAN MODE)';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(
					':search' => $search,
					':state' => $state
				));
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
		 * Get all vouchers in a category
		 */
		static public function GetAllInCategoryForEdition($edition,$categoryId) {
			try
			{		

				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT v.* FROM `voucher` v WHERE categoryId = :categoryId AND validFrom <= CURDATE() AND validTo >= CURDATE() ORDER BY businessName ASC';
				//				$sqlStatement = 'SELECT v.*, r.name AS regionName FROM `voucher` v LEFT JOIN WHERE categoryId = :categoryId AND validFrom <= CURDATE() AND validTo >= CURDATE() ORDER BY validTo DESC, businessName ASC';
				
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':categoryId'=>$categoryId));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				if($_SERVER['REMOTE_ADDR']=='1.128.110.145'){
				//	print_r($rsResults);
				}
				
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
		 * Get all vouchers in a category & region
		 */
		static public function GetAllInCategoriesAndRegionForEdition($edition,$categoryIds,$regionId) {
//			echo "$edition,$categoryIds,$regionId"; exit;
			try
			{		


				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT v.* FROM `voucher` v 
								LEFT JOIN `voucherRegion` vr
								ON v.id = vr.voucherId
								WHERE v.categoryId IN ('.$categoryIds.') AND v.validFrom <= CURDATE() AND v.validTo >= CURDATE() 
								AND vr.regionId = :regionId
								ORDER BY v.businessName ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':regionId'=>$regionId));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				if($_SERVER['REMOTE_ADDR']=='1.128.107.92'){
					print_r($rsResults);
				}
				
//					print_r($rsResults);
//					print_r($sth->errorInfo()); exit;
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
		 * Get all vouchers in a region
		 *
		static public function GetAllInRegionForEdition($edition,$regionId) {
			try
			{		
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT v.* FROM `voucher` v WHERE edition = :edition AND (regionId = :regionId OR regionId = 0) ORDER BY edition DESC, businessName ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':edition'=>$edition, ':regionId'=>$regionId));
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
*/



		/*	 	 
		 * Delete report based on id
		 */
		static public function Delete($id) {
			try
			{	
				
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'DELETE	FROM `voucher`							
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
	static public function Update($voucherObj) {
		
		if(!$voucherObj->neatIdeasType)
			$voucherObj->neatIdeasType = 0;
		if(!$voucherObj->neatIdeasId)
			$voucherObj->neatIdeasId = 0;
		
		try
		{		
			$oDbConnection = new DAL_PDO();			
			$sqlStatement = 'UPDATE `voucher` SET					
				`businessName` = :businessName,					
				`title` = :title,					
				`phone` = :phone,
				`address` = :address,
				`state` = :state,
				`web` = :web,					
				`categoryId` = :categoryId,
				`description` = :description,
				`businessDescription` = :businessDescription,
				`image` = :image,
				`validFrom` = :validFrom,
				`validTo` = :validTo,
				`allowMonthlyUse` = :allowMonthlyUse,
				`isOnlineCoupon` = :isOnlineCoupon,
                `onlineCouponText` = :onlineCouponText,
				`neatIdeasType` = :neatIdeasType,
				`neatIdeasId` = :neatIdeasId
			 	WHERE id = :id
				LIMIT 1';			
			$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
			$sth->execute(array(				
				':id' => $voucherObj->id,							
				':businessName' => $voucherObj->businessName,					
				':title' => $voucherObj->title,														
				':phone' => $voucherObj->phone,
				':address' => $voucherObj->address,					
				':state' => $voucherObj->state,					
				':web' => $voucherObj->web,
				':categoryId' => $voucherObj->categoryId,
				':description' => $voucherObj->description,
				':businessDescription' => $voucherObj->businessDescription,
				':image' => $voucherObj->image,
				':validFrom' => $voucherObj->validFrom,
				':validTo' => $voucherObj->validTo,
				':allowMonthlyUse' => $voucherObj->allowMonthlyUse,
				':isOnlineCoupon' => $voucherObj->isOnlineCoupon,
                ':onlineCouponText' => $voucherObj->onlineCouponText,
				':neatIdeasType' => $voucherObj->neatIdeasType,
				':neatIdeasId' => $voucherObj->neatIdeasId					
			));	
		//	print_r($voucherObj->onlineCouponText);			
		//	print_r($sth->errorInfo());
			$rsResult = $sth->rowCount();  //will still be 0 if no error, but no records updated
			
			return $voucherObj->id;
			
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
		
		if(!$voucherObj->neatIdeasType)
			$voucherObj->neatIdeasType = 0;
		if(!$voucherObj->neatIdeasId)
			$voucherObj->neatIdeasId = 0;
		
		try
		{					
								
			$oDbConnection = new DAL_PDO();			
			$sqlStatement = 'INSERT INTO `voucher` (businessName,title,phone,address,state,web,categoryId,description,businessDescription,image,validFrom,validTo,allowMonthlyUse,isOnlineCoupon,onlineCouponText,neatIdeasType,neatIdeasId) 
							        VALUES (:businessName,:title,:phone,:address,:state,:web,:categoryId,:description,:businessDescription,:image,:validFrom,:validTo,:allowMonthlyUse,:isOnlineCoupon,:onlineCouponText,:neatIdeasType,:neatIdeasId)';
			$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
			$sth->execute(array(											
				':businessName' => $voucherObj->businessName,					
				':title' => $voucherObj->title,														
				':phone' => $voucherObj->phone,
				':address' => $voucherObj->address,					
				':state' => $voucherObj->state,					
				':web' => $voucherObj->web,
				':categoryId' => $voucherObj->categoryId,
				':description' => $voucherObj->description,
				':businessDescription' => $voucherObj->businessDescription,
				':image' => $voucherObj->image,
				':validFrom' => $voucherObj->validFrom,
				':validTo' => $voucherObj->validTo,
				':allowMonthlyUse' => $voucherObj->allowMonthlyUse,
				':isOnlineCoupon' => $voucherObj->isOnlineCoupon,
                ':onlineCouponText' => $voucherObj->onlineCouponText,
				':neatIdeasType' => $voucherObj->neatIdeasType,
				':neatIdeasId' => $voucherObj->neatIdeasId
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