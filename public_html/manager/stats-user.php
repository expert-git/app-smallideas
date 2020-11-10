<?php
	
	//
	// find out how many redeems each active user has done, export to csv
	//

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");
	include_once(EPABSPATH."/include/classes/DAL/WPuser.class.php");
	

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
	

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/masterAdmin.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewStatsAdmin.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	
	
	//get WP user accounts and phone numbers and suburb
	$wpUserObjArr = DAL_WP_User::GetAll();
	$wpUserMetaObjArr = DAL_WP_User::GetMeta();	

	//join all meta data into array
	$udata = array();
	foreach($wpUserObjArr as $u){
		$udata[$u->ID]['email'] = $u->user_email;	
	}
	foreach($wpUserMetaObjArr as $um){
		if(isset($udata[$um->user_id])){
			$udata[$um->user_id][$um->meta_key] = $um->meta_value;
		}
	}
	
	//shuffle
	$currentUsers = array();
	foreach($udata as $uo){
		$currentUsers[$uo['email']] = $uo;
	}
	//print_r($currentUsers); exit;
	

	//get all active app users from DB
	$userObjArr = DAL_User::GetAllActiveByLastRenewed();
	
	
	//get userhistory for each active user	
	foreach($userObjArr as $userObj){
		$historyObjArr = DAL_UserHistory::GetAbsolutelyAllForUser($userObj->id);
		$userObj->redeems = count($historyObjArr);
		$em = strtolower($userObj->email);
	//	echo "\n".$em."\n";
		if(isset($currentUsers[$em])){
			$userObj->phone = str_replace('"','',$currentUsers[$em]['billing_phone']);
			$userObj->suburb = str_replace('"','',$currentUsers[$em]['billing_city']);
			$userObj->postcode = str_replace('"','',$currentUsers[$em]['billing_postcode']);
		}
		
	}
	//print_r($userObjArr); exit;
	

	//create a file pointer
	$delimiter = ",";
    $filename = "User_Reedeems_" . date('Y-m-d') . ".csv";
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('email','phone','last renewal','redeems','suburb','postcode','state','user group');
    fputcsv($f, $fields, $delimiter);
	

	
	foreach ($userObjArr as $u)
	  {
	  	fputcsv($f,array($u->email," ".$u->phone,$u->lastRenewed,$u->redeems,$u->suburb,$u->postcode,$u->state,$u->userGroup),$delimiter);
	  }
	  
	  //move back to beginning of file
	      fseek($f, 0);
	
	
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Pragma: no-cache');
    header('Expires: 0');

	//output all remaining data on a file pointer
    fpassthru($f);
		



?>