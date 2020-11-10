<?php
	
	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");
	include_once(EPABSPATH."/include/classes/category.class.php");

	/* check authentication and process login if required */
	include_once(EPABSPATH."/include/classes/auth.class.php");  	

	//is admin?
    $isAdmin = ((isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) && ($_SESSION['adminMode']==ADMIN));

	//get from db
	$passwordResetUrl = (isset($_GET['id'])) ? Service::cleanString($_GET['id']) : "";
	
	if($passwordResetUrl){
		$userObj = DAL_User::GetByPasswordResetUrl($passwordResetUrl);
	}
	
	$catArr = X_Category::GetAll();
	
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');

	if($userObj){

		//setup page templates		
		$pageTemplate = new Template(EPABSPATH.'/templates/viewPasswordReset.tmpl.php');
		$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template	

		//set template variables
		$template->title = "Small Ideas | Reset Password";		
		$template->isAdmin = $isAdmin;		
		$template->userObj = $userObj;
		$template->catArr = $catArr;
		$template->pagestyles = '';
		$template->pagescripts = '';
		$template->heading = "Password Reset";	
		$template->bodyClass = 'password';
		
		//display page
		$template->content = $pageTemplate->run();	//generate inner page content
		echo $template;	//echo master
		

	} else {

		// 404 Not Found
		//setup page templates
		$pageTemplate = new Template(EPABSPATH.'/templates/view404.tmpl.php');
		$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
		//set template variables
		$template->title = "404 Not Found";
		$template->pagestyles = '';
		$template->userObj = null;
		$template->catArr = $catArr;
		$template->pagescripts = '';
		$template->isAdmin = $isAdmin;	
		$template->heading = "Not found";
		$template->bodyClass = 'password';
		
		//display page
		$template->content = $pageTemplate->run();	//generate inner page content
		echo $template;	//echo master		
		exit;


	}
	


?>