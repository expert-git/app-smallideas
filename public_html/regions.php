<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	/* core inclusions */
	include_once("../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/region.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);
	
	//get user, so can work out state
	$userObj = DAL_User::GetById($_SESSION['userid']);
	
	//STATES that go straight to the vouchers
	$statesStraightToVouchersArr = array("NSW","QLD","WA","SA");

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');


	$pageTemplate = new Template(EPABSPATH.'/templates/viewRegions.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//get regions
	$regionObjArr = DAL_Region::GetAll($userObj->state); 
	
	//set template vars
	$template->backlink = "/";
	$template->regionObjArr = $regionObjArr;
	$template->bodyClass = 'regions';
	$template->title = "Small Ideas";
	$template->isAdmin = $isAdmin;
	$template->userObj = $userObj;
	$template->statesStraightToVouchersArr = $statesStraightToVouchersArr;
	$template->heading = "Regions";
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>