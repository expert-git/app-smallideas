<?php

	/* core inclusions */
	include_once("../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewHidden.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//get redeem history 	
	$voucherObjArr = DAL_UserHidden::GetAllForUser($_SESSION['userid']);
	

	//set template vars
	$template->voucherObjArr = $voucherObjArr;	
	$template->heading = "Hidden Vouchers";
	$template->title = "Small Ideas | Hidden Vouchers";
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'categories';
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>