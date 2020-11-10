<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
	
	require_once("wp-xpdo.class.php");

	/**
	 * @TODO Update this reference if and when a common business object is created
	 */
	include_once(EPABSPATH."/include/classes/BO/user.class.php");
	
	class DAL_WP_User {
		


		/*	 	 
		 * Get all user accounts and phone numbers from WP. 
		 */
		static public function GetAll() {
			try
			{		//exit;
				$oDbConnection = new DAL_WP_PDO();			
				$sqlStatement = "SELECT u.user_email,u.ID FROM wp_users u";
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
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
		 * Get user META from WP
		 */
		static public function GetMeta() {
			try
			{		//exit;
				$oDbConnection = new DAL_WP_PDO();			
				$sqlStatement = "SELECT um.user_id,um.meta_key,um.meta_value FROM wp_usermeta um WHERE um.meta_key = 'billing_phone' OR um.meta_key = 'billing_city' OR um.meta_key = 'billing_postcode'";
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
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