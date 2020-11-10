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
	$pageTemplate = new Template(EPABSPATH.'/templates/viewVouchersAdmin.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	
	//show only for given state
	$currentState = (isset($_GET['state'])) ? $_GET['state'] : 'VIC';
	$currentState = Service::cleanTitle($currentState);

	//get vouchers for state
	$voucherObjArr = DAL_Voucher::GetAll($currentState);

	//set template variables
	$template->title = " Vouchers | Small Ideas";
	$template->isAdmin = $isAdmin;
	$template->activeTab = 'vouchers';
	$template->bodyClass = '';
	$template->voucherObjArr = $voucherObjArr;
	$template->pagelevelCSS = '';
	$template->pagelevelScripts = '<script src="/js/table-datatables-editable-vouchers.js" type="text/javascript"></script>';

	
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>