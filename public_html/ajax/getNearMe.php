<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	
	/* database classes required for page */			
	include_once(EPABSPATH."/include/classes/DAL/voucherLocation.class.php");
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");
	
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");	

	if(isset($_SESSION['userid']) && $_SESSION['userid']){
	
		//print_r($_POST); exit;

		if(isset($_POST['lat']) && isset($_POST['lng'])){
			
			$lat = Service::cleanNumeric($_POST['lat']);
			$lng = Service::cleanNumeric($_POST['lng']);

			//get all voucher locations (where vouchers are valid)
			$voucherLocationObjArr = DAL_VoucherLocation::GetAllActive();
			//print_r($voucherLocationObjArr); exit;
			
			//calculate distances
			foreach($voucherLocationObjArr as $voucherLocationObj){
				$distance = distance($lat,$lng,$voucherLocationObj->lat,$voucherLocationObj->lng);
				$voucherLocationObj->distance = $distance;
			}
		
			//sort by distance
			usort($voucherLocationObjArr, "cmpDistance");
			//print_r($voucherLocationObjArr); exit;
			
			
			//get vouchers used by the user
			$userObj = DAL_User::GetById($_SESSION['userid']);
			$userHistoryArr = DAL_UserHistory::GetAllForUser($_SESSION['userid'],$userObj->lastRenewed);
			//restructure array
			$userHistoryObjArr = array();
			foreach($userHistoryArr as $uo){
				$userHistoryObjArr[$uo->voucherId] = $uo;
			}
			
			//check hidden vouchers
			$userHiddenObjArr = DAL_UserHidden::GetAllForUser($_SESSION['userid']);
			$userHiddenArr = array();
			if($userHiddenObjArr){
				foreach($userHiddenObjArr as $uhObj){
					$userHiddenArr[$uhObj->id] = 1;
				}
			}
			

			//generate array
			$count=0;
			$results = array();
			foreach($voucherLocationObjArr as $voucherLocationObj){
				
				if(!isset($userHiddenArr[$voucherLocationObj->voucherId])){
					
					$voucherObj = DAL_Voucher::GetById($voucherLocationObj->voucherId);
					$results[] = array(
						'id' => $voucherObj->id,
						'businessName' => $voucherObj->businessName,
						'title' => $voucherObj->title,
						'address' => $voucherObj->address,
						'km' => $voucherLocationObj->distance,
						'redeemed' => (isset($userHistoryObjArr[$voucherObj->id]) && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=1 && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=2) ? 'redeemed' : ''		
					);
					$count++;
					if($count>20)
						break;
					
				}
				
			}
			//print_r($results); exit;

	
			if($results){
				echo json_encode(array('success'=>1,'results'=>$results));
				exit;
			} else {
				echo json_encode(array('success'=>0));
				exit;
			}				


		} 
	}

	function cmpDistance($a, $b){
	    if ($a->distance == $b->distance) {
	        return 0;
	    }
	    return ($a->distance < $b->distance) ? -1 : 1;
	}

	function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K') {
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
		      return (round($miles * 1.609344,3));
		  } else if ($unit == "N") {
		      return ($miles * 0.8684);
		  } else {
		      return $miles;
		  }
	}

	echo json_encode(array('success'=>0));
	
?>