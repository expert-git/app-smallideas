<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	require_once("xpdo.class.php");
	
	include_once(EPABSPATH."/include/classes/BO/region.class.php");
	
	class DAL_Region {


		/*	 	 
		 * Get all regions
		 */
		static public function GetAll($state = null) {
			$stateSql = ($state) ? "WHERE state = '$state'" : '';

			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `region` '.$stateSql;
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':state'=>$state));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_Region($aResult);
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
		 * Get 'visit' regions
		 */
		static public function GetVisitRegions($state = 'VIC') {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `region` WHERE state = :state AND name LIKE "Visit %"';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':state'=>$state));
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_Region($aResult);
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
		static public function GetById($regionId) {
			try
			{		
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `region`
								WHERE id = :id 
								LIMIT 1';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id'=>$regionId));
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);
								
				if($sth->rowCount()>0){ 					
					$obj = new BO_Region($rsResults);				
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