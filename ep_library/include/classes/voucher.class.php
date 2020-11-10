<?php 


	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/


include_once ('DAL/voucher.class.php');
include_once ('DAL/voucherRegion.class.php');
include_once ('DAL/voucherLocation.class.php');
include_once ('auth.class.php');

/**
 * 
 * 
 */
class X_Voucher
{
	
	
	/* update/create voucher */
	public static function Update($postArr){		

		//clean inputs
		$cleanArr = array();
		
		foreach($postArr as $key => $val){	
			switch($key){				
				case "web":
					$val = str_replace(array("http://","https://"),"",$val);
					$cleanArr[$key] = Service::cleanUrl($val);
					break;
				case "categoryId":
				case "edition":					
					$cleanArr[$key] = Service::cleanNumeric($val);
					break;
				case "description":
				case "onlineCouponText":				
				case "businessDescription":					
					$cleanArr[$key] = Service::cleanHTML($val);
					break;
				case "location-group":
					foreach($val as $location){
						$cleanArr[$key][] = array(
							'address' => Service::cleanHTML($location['address']),
							'lat' => Service::cleanNumeric($location['lat']),
							'lng' => Service::cleanNumeric($location['lng'])
						);

					}
					break;
				default:
					$cleanArr[$key] = Service::cleanString($val);
			}				 				
		}


		//regions
		$regionObjArr = array();
		foreach($cleanArr as $key => $val){
			if(strpos($key,'region-')!==false){
				$parts = explode('-',$key);
				$regionObjArr[] = new BO_VoucherRegion(array(
					'regionId' => $parts[1]
				));
			}
		}

		//voucherobj
		if(isset($cleanArr['voucherId'])){
			$voucherObj = DAL_Voucher::GetById($cleanArr['voucherId']);
		}
		// echo "\n\n";
		// print_r($voucherObj);
		// echo "\n\n";
		// print_r($cleanArr);
		// 		echo "\n\n";
		// 		print_r($_POST);

		if(!(isset($voucherObj))){
			$voucherObj = new BO_Voucher();
		}

		//update 
		foreach($cleanArr as $key => $val){			
			$voucherObj->{$key} = $val;
		}
		
		//save
//		print_r($voucherObj);
		$id = $voucherObj->save();

		//delete existing regions
		$delresult = DAL_VoucherRegion::DeleteAllForVoucherId($id);

		//add regions
		foreach($regionObjArr as $regionObj){
			$regionObj->voucherId = $id;
			//print_r($regionObj);
			$regionObj->save();
		}

		//delete existing locations
		$dellocresult = DAL_VoucherLocation::DeleteAllForVoucherId($id);

		//add locations
		if($cleanArr['location-group']){
			foreach($cleanArr['location-group'] as $location){
			//	print_r($location);
				$voucherLocationObj = new BO_VoucherLocation(array(					
					'voucherId' => $id,
					'address' => $location['address'],
					'lat' => $location['lat'],
					'lng' => $location['lng']
				));
				$voucherLocationObj->save();
			}
		}


		return $id;


	}



	public static function GetById($id){

		//get voucher details
		$voucherObj = DAL_Voucher::GetById($id);

		//get regions for voucher
		$voucherRegionObjArr = DAL_VoucherRegion::GetAllForVoucherId($id);

		//add to object
		$regions = array();		
		if($voucherRegionObjArr){
		foreach($voucherRegionObjArr as $voucherRegionObj){			
			$regions[$voucherRegionObj->regionId] = $voucherRegionObj->regionId;
		}		
		}
		$voucherObj->regions = $regions;
	

		return $voucherObj;

	}



	static public function GetAllInRegionForEdition($edition,$regionId){

		//get all voucher id's for region
		$voucherRegionObjArr = DAL_VoucherRegion::GetAllForRegionId($regionId);
		
		//get all voucher obj's 
		$voucherObjArr = array();
		if($voucherRegionObjArr){
			foreach($voucherRegionObjArr as $voucherRegionObj){
				$voucherObj = DAL_Voucher::GetById($voucherRegionObj->voucherId);
				if($voucherObj && $voucherObj->validFrom <= date('Y-m-d') && $voucherObj->validTo >= date('Y-m-d')){
					$voucherObjArr[] = $voucherObj;
				}
			}		
		}
		
		//sort by businessName
		usort($voucherObjArr,array('X_Voucher','voucher_cmp'));
		
		// if($_SERVER['REMOTE_ADDR']=='1.132.107.62'){
// 			//print_r($voucherObjArr);
// 		}
//
		return $voucherObjArr;
		
		
		
	}
	
	
	//sorting vouchers by business name
	private static function voucher_cmp($a, $b){
	    if ($a->businessName == $b->businessName) {
	        return 0;
	    }
	    return ($a->businessName < $b->businessName) ? -1 : 1;
	}
	





}

?>