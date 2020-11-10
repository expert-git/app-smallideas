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
	include_once(EPABSPATH."/include/classes/voucher.class.php");	
	include_once(EPABSPATH."/include/classes/service.class.php");

	//		print_r($_POST);
	if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
	
		/* validataion */
		if(
			($_POST['businessName']=='') ||
			($_POST['title']=='') ||
			($_POST['categoryId']=='') ||			
			($_POST['description']=='')
		){
			echo json_encode(array('success'=>0,'reason'=>'validation')); exit;
		}

		if(isset($_POST) && count($_POST)>5){
			
			if(isset($_POST['onlineCouponFix']) && isset($_POST['isOnlineCoupon']) && $_POST['isOnlineCoupon']=="1")
				$_POST['onlineCouponText'] = $_POST['onlineCouponFix'];
			
			if(isset($_POST['experienceOzLink']) && isset($_POST['isOnlineCoupon']) && $_POST['isOnlineCoupon']=="3")
				$_POST['onlineCouponText'] = $_POST['experienceOzLink'];
			
		//	print_r($_POST);
			
			$result = X_Voucher::Update($_POST);

			if($result > 0){
				//all good!
				echo json_encode(array('success'=>1));						
			} else {
				//couldn't update
				echo json_encode(array('success'=>0,'reason'=>'unknown'));		
			}

		} else {
			echo json_encode(array('success'=>0));
			exit;
		}
		exit;
	}

	echo json_encode(array('success'=>0));
	
?>