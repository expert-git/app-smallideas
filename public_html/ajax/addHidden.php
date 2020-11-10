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
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	if(isset($_SESSION['userid']) && $_SESSION['userid']){
	
		if(isset($_POST['voucherid'])){
			$userId = $_SESSION['userid'];
			$voucherId = Service::cleanNumeric($_POST['voucherid']);
//			echo "$userId - $vourcherId";
			$userHiddenObj = DAL_UserHidden::GetByUserAndVoucher($userId,$voucherId);

			if(!$userHiddenObj){
				//doesnt exist, so add favourite
				$result = DAL_UserHidden::Create($userId,$voucherId);
				if($result){
					echo json_encode(array('success'=>1,'action'=>'create'));
					exit;
				} else {
					echo json_encode(array('success'=>0,'reason'=>'Couldnt create'));
					exit;
				}				

			} else {
				//exists, so delete
				$result = DAL_UserHidden::Delete($userId,$voucherId);
				if($result){
					echo json_encode(array('success'=>1,'action'=>'delete'));
					exit;
				} else {
					echo json_encode(array('success'=>0,'reason'=>'Couldnt create'));
					exit;
				}	
			}

		} 
	}

	echo json_encode(array('success'=>0));
	
?>