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
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	// print_r($_POST); 
	//print_r($_SESSION);

	if(isset($_POST['id']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){

		$id = Service::cleanNumeric($_POST['id']);
				
		$voucherObj = DAL_Voucher::GetById($id);

		if($voucherObj){
			$voucherObj->title = $voucherObj->title." - COPY";
			//remove id so it copies it.
			$voucherObj->id = null;
			$newid = $voucherObj->save();
		} else {
			echo json_encode(array('success'=>0));
			exit;
		}

		if(!$newid){
			//couldn't update
			echo json_encode(array('success'=>0));
		} else {
			//all good!			
			echo json_encode(array('success'=>1,'newid'=>$newid));
		}
	} else {
		echo json_encode(array('success'=>0));
		exit;
	}


	
?>