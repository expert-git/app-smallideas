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
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	if((isset($_SESSION['userid']) && $_SESSION['userid']) || isset($_SESSION['allow-insecure'])){
	
		if(isset($_POST['voucherid'])){

			$voucherObj = DAL_Voucher::GetById(Service::cleanNumeric($_POST['voucherid']));

			if(!$voucherObj){
				echo json_encode(array('success'=>0,'reason'=>'voucher not found'));
				exit;
			}

			//ensure voucher is still valid
			$now = date('Y-m-d');
			if($now < $voucherObj->validFrom || $now > $voucherObj->validTo ){
				echo json_encode(array('success'=>0,'reason'=>'voucher expired'));
				exit;
			}
			
			
			if(isset($_SESSION['allow-insecure'])){
				
				$userId = 0;
				$existingHistoryObj = null;
					
			} else {
				
				$userId = $_SESSION['userid'];

				//ensure user is allowed to redeem
				if($voucherObj->allowMonthlyUse == 1){
					$existingHistoryObj = DAL_UserHistory::GetByMonthlyRecurring($userId,$voucherObj->id);
				} else if($voucherObj->allowMonthlyUse == 2){
					$existingHistoryObj = DAL_UserHistory::GetByWeeklyRecurring($userId,$voucherObj->id);
				} else {
					$existingHistoryObj = DAL_UserHistory::GetByUserAndVoucher($userId,$voucherObj->id);
				}
				
			}

			if($existingHistoryObj){
				echo json_encode(array('success'=>0,'reason'=>'voucher already redeemed'));
				exit;
			}
			
			//get user group
			$userObj = DAL_User::GetById($userId);
			$userGroup = ($userObj) ? $userObj->userGroup : null;

			$userHistoryObj = new BO_UserHistory(array(
				'dateRedeemed' => date('Y-m-d'),
				'userId' => $userId,
				'userGroup' => $userGroup,
				'voucherId' => $voucherObj->id,
				'businessName' => $voucherObj->businessName,
				'title' => $voucherObj->title
			));
			//print_r($userHistoryObj);
			$result = $userHistoryObj->save();
			
			if($result){
				echo json_encode(array('success'=>1));	
			} else {
				echo json_encode(array('success'=>0));
			}
		} else {
			echo json_encode(array('success'=>0));
			exit;
		}
		exit;
	}

	echo json_encode(array('success'=>0));
	
?>