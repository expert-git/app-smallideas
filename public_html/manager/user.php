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
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");
	//include_once(EPABSPATH."/include/classes/DAL/userEdition.class.php");

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
	
	if(isset($_GET['id'])){
		$userObj = DAL_User::GetById(Service::cleanNumeric($_GET['id']));	
		//if($userObj)
		//	$userEditionObjArr = DAL_UserEdition::GetAllForUser($userObj->id);
	}
	if(!isset($userObj))
		$userObj = null;
	
	//if(!isset($userEditionObjArr))
	//	$userEditionObjArr = null;

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/masterAdmin.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/editUser.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	

	//set template variables
	$template->title = "Edit User | Small Ideas";
	$template->isAdmin = $isAdmin;	
	$template->activeTab = 'users';
	$template->bodyClass = '';
	$template->userObj = $userObj;
	//$template->userEditionObjArr = $userEditionObjArr;
	$template->pagelevelCSS = '<link href="/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />';
	$template->pagelevelScripts = '<script src="/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>';

	
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>