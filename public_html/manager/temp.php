<?php
	
	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
	include_once(EPABSPATH."/include/classes/category.class.php");
	

	/* check authentication and process login if required */
	include_once(EPABSPATH."/include/classes/auth.class.php");	 
	
	
	
	exit;
	
	/*
	 * send email to accounts that are expiring in x days
	 */
	
	$sendDaysBeforeExpiry = 3;
	$userObjArr = DAL_User::GetExpiringInDays($sendDaysBeforeExpiry);
	
	$subject = 'REMINDER';
	$emailContent = new Template(EPABSPATH.'/templates/emailSubscriptionRenewal.tmpl.php');
	$emailContent->days = $sendDaysBeforeExpiry;
		
	if($userObjArr){
		foreach($userObjArr as $userObj){
			//send email				
			if($userObj->email=='gav@entice.com.au'){
				$result = Service::sendMessage(array($userObj->email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		 
				echo $result;
			}
		 }
	 }
	 
	 
	 
	
	exit;
	
	//check categories for vouchers
	
	$nsw = array(18,32,31,20,19,17);
	$qld = array(14,15,16,33,13);
	$sa = array(23,22,21,34);
	$wa = array(24,30,29,28,26,25,27);
	
	$voucherObjarrr = DAL_Voucher::GetAll();
	
	$badArr = array();
	
	foreach($voucherObjarrr as $v){
		switch($v->state){
			case 'NSW':
				$arr = $nsw;
				break;
			case 'QLD':
				$arr = $qld;
				break;
			case 'SA':
				$arr = $sa;
				break;
			case 'WA':
				$arr = $wa;
				break;
		}
		
		if(isset($arr)){
			
			if(in_array($v->categoryId,$arr)){
				//ok
			} else {
				$badArr[] = $v->id;
			}
			
		}
		
		unset($arr);
	}
	
	if($badArr){
		foreach($badArr as $vId){
			$voucherObj = DAL_Voucher::GetById($vId);
			$categoryObj = DAL_Category::GetById($voucherObj->categoryId);
			echo $voucherObj->id." ".$categoryObj->name." ".$voucherObj->state."\n";
			
			if($voucherObj->state == 'SA' && $voucherObj->categoryId = 4){
				$voucherObj->categoryId = 34;
			//	$voucherObj->save();
//				echo '  HERE. ';
			}
		}
	}
	
	
	exit;
	
	///////////////////////////////////////////
	
	
	
	$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser(10100); 
	print_r($userHistoryObjArr);
	exit;

	
	// //clear user history for all users in the last 4 months
	$count = 0;
	$userObjArr = DAL_User::GetAllRenewedSince();
	//print_r($userObjArr); exit;
	//echo count($userObjArr); exit;

	foreach($userObjArr as $uObj){
		$allClear = true;

		$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser($uObj->id);

		foreach($userHistoryObjArr as $historyObj){
			if($historyObj->isDeleted != 1){
				$allClear = false;
			};
		}

		if($allClear == false){
			$count++;
			echo "{$uObj->id}\n";
		}

	}
	echo "count-".$count;
	exit;

	/////////////////////


// //clear user history for all users in the last 4 months
$count = 0;
$userObjArr = DAL_User::GetAllRenewedSince();

foreach($userObjArr as $uObj){
	$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser($uObj->id);
	foreach($userHistoryObjArr as $historyObj){
		if($historyObj->isDeleted != 1){
			$historyObj->isDeleted = 1;
			$historyObj->save();
		}
	}


}
exit;
//
// /////////////////////



	
	
		
	//clear user history object
	$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser(9818);
	
	foreach($userHistoryObjArr as $historyObj){
		$historyObj->isDeleted = 1;
		$historyObj->save();
	}
	
	$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser(9818);
	print_r($userHistoryObjArr);
	exit;
	
  	
	exit;
	
	$userObjArr = DAL_User::GetAll();
	$filteredArr = array();
	
	foreach($userObjArr as $u){
		//get renewals since jan
		if($u->lastRenewed > '2019-01-02' && $u->registeredDateTime < '2018-12-01 16:17:41'){
			$filteredArr[] = $u;
		}
	}
	//echo count($filteredArr);
	foreach($filteredArr as $uf){
		
		//clear user history object
		$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser($uf->id);
		foreach($userHistoryObjArr as $historyObj){
			if($historyObj->isDeleted == 0){
				$historyObj->isDeleted = 1;
				$historyObj->save();
			}
		}		
		echo count($userHistoryObjArr)."<br>";			
		unset($userHistoryObjArr);
	}
	

?>