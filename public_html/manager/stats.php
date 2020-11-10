<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */
	
	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
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
	

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/masterAdmin.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewStatsAdmin.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	


	//get redeems
	// $year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
// 	$month = (isset($_GET['month'])) ? $_GET['month'] : date('m');
// 	$voucher = (isset($_GET['voucher'])) ? $_GET['voucher'] : '';
//
	$year = (isset($_GET['year'])) ? $_GET['year'] : "";
	$month = (isset($_GET['month'])) ? $_GET['month'] : "";
	$voucher = (isset($_GET['voucher'])) ? $_GET['voucher'] : "";	
	$state = (isset($_GET['state'])) ? $_GET['state'] : "";
	
	$voucherHistoryObjArr = DAL_UserHistory::GetStats($year,$month,$voucher,$state);

	$sortedVoucherHistoryObjArr = array();
	$voucherHistoryCount = array();
	if($voucherHistoryObjArr){
		foreach($voucherHistoryObjArr as $hObj){
			//just get once instance of each
			$sortedVoucherHistoryObjArr[$hObj->voucherId] = $hObj;
			//get count
			$voucherHistoryCount[$hObj->voucherId] = (isset($voucherHistoryCount[$hObj->voucherId])) ? $voucherHistoryCount[$hObj->voucherId]+1 : 1;
		}
	}
	
	
	//for select
	$availableVoucherHistoryObjArr = DAL_UserHistory::GetAllUnique();
	


									
	//set template variables
	$template->title = " Stats | Small Ideas";
	$template->isAdmin = $isAdmin;
	$template->activeTab = 'stats';
	$template->bodyClass = '';
	$template->availableVoucherHistoryObjArr = $availableVoucherHistoryObjArr;
	$template->sortedVoucherHistoryObjArr = $sortedVoucherHistoryObjArr;
	$template->voucherHistoryCount = $voucherHistoryCount;
	$template->totalCount = "(Total ".count($voucherHistoryObjArr).")";
	$template->pagelevelCSS = '';
	$template->pagelevelScripts = '';

	
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>