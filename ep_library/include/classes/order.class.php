<?php 
	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
include_once('auth.class.php');
include_once("BO/voucher.class.php");
class Order
{	
		/*	 	 
		 * Get all Order
		 */
		static public function GetAll($state = NULL){
			
			$where = ($state) ? "WHERE state = '{$state}'" : '';
			
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();	
				$sqlStatement = 'SELECT o.*, v.businessName, v.title FROM `orders` o LEFT JOIN `voucher` v ON o.vId = v.id ORDER BY o.id DESC';
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
		
		static public function GetSingleOrder($id){			
			try{		//exit;
				$oDbConnection = new DAL_PDO();	
				$sqlStatement = 'SELECT o.*, v.businessName, v.title FROM `orders` o LEFT JOIN `voucher` v ON o.vId = v.id WHERE o.id = :id';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':id' => $id));				
				$rsResults = $sth->fetch(PDO::FETCH_ASSOC);
				
			  if($sth->rowCount()>0){ return new BO_Voucher($rsResults);}
			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}
		
		static public function GetOrderItems($oid){
			
			try{	
				$oDbConnection = new DAL_PDO();	
				$sqlStatement = 'SELECT oi.*, vp.fileName FROM `orderItems` oi LEFT JOIN `voucherPdf` vp ON vp.id = oi.itemId WHERE oi.orderId = :oId ORDER BY oi.id DESC';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute(array(':oId' => $oid));	
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
				
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
		
	/*update/create*/
	public static function Update($postArr){
		//clean inputs
		$cleanArr = array();
		
		foreach($postArr as $key => $val){	
			switch($key){
				default:
				 $cleanArr[$key] = Service::cleanString($val);
			}				 				
		}
		if(isset($cleanArr['voucherPdfId'])){			
		 if(!isset($cleanArr['fileName'])){
			$voucherPdfObj = DAL_VoucherPdf::GetById($cleanArr['voucherPdfId']);
			$cleanArr['fileName'] = $voucherPdfObj->fileName;
		 }
			$id = DAL_VoucherPdf::Update($cleanArr);
		} else {
			$id = DAL_VoucherPdf::Create($cleanArr);
		}		
		return $id;
	}

	public static function GetById($id){
		//get voucher details
		$voucherObj = DAL_VoucherPdf::GetById($id);
		return $voucherObj;
	}
}
?>