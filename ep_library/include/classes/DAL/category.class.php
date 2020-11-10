<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	require_once("xpdo.class.php");
	
	include_once(EPABSPATH."/include/classes/BO/category.class.php");
	
	class DAL_Category {


		/*	 	 
		 * Get all categories
		 */
		static public function GetAll() {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `category`
								ORDER BY displayOrder ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_Category($aResult);
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
		 * Get all categories
		 */
		static public function GetAllForParentId($categoryId = 0, $state = 'VIC') {

			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `category`
								WHERE parentId = :parentId
								AND state = :state
								ORDER BY displayOrder ASC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':parentId'=>$categoryId,':state'=>$state));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_Category($aResult);
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
		 * Get by Id
		 */
		static public function GetById($categoryId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `category`
								WHERE id = :id 
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$categoryId));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 					
					$obj = new BO_Category($rsResults);				
					return $obj;
				}								
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}














		
		
	}


?>