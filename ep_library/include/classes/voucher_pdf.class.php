<?php 
	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
include_once('DAL/voucherPdf.class.php');
include_once('auth.class.php');

class Voucher_Pdf
{	
	
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