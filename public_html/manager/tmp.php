<?php
	
	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/voucherRegion.class.php");
	include_once(EPABSPATH."/include/classes/category.class.php");
	

	/* check authentication and process login if required */
	include_once(EPABSPATH."/include/classes/auth.class.php");	 
  	
	//show login if required, update session time
	X_Auth::Login(); 
	
	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);
	
	if(!$isAdmin){
		session_destroy();
		unset($_COOKIE['remember']);
		header("Location: /manager/");
		exit;
	}
	


	$voucherObjArr = DAL_Voucher::GetAll();

	foreach($voucherObjArr as $voucherObj){


echo "{$voucherObj->regionId}\n";

		// if(trim($voucherObj->regionId)){
		// 	if(strpos($voucherObj->regionId,'ALL')!==false){

		// 		$vrObj = new BO_VoucherRegion(array(
		// 			'voucherId' => $voucherObj->id,
		// 			'regionId' => 1
		// 		));
		// 		$result = $vrObj->save();

				
					
		// 		$voucherObj->regionId = str_replace('ALL','',$voucherObj->regionId);

		// 	}

		// 	$voucherObj->save();
		// }

		

	}


?>