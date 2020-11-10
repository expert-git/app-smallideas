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
	//include_once(EPABSPATH."/include/classes/DAL/category.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');

	$pageTemplate = new Template(EPABSPATH.'/templates/viewMainMenu.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//add to home screen
	$addToHomeScreen = '<script src="/js/addtohomescreen.min.js"></script>
			<script>
				addToHomescreen({
					maxDisplayCount: 2
				});
			</script>
			';

	//set template vars
	$template->title = "Small Ideas";
	$template->isAdmin = $isAdmin;
	$template->bodyClass = 'main-menu';
	$template->pagelevelCSS = '<link rel="stylesheet" type="text/css" href="/css/addtohomescreen.css">';	
	$template->pagelevelScripts = (isset($_GET['app'])) ? '' : $addToHomeScreen;  //maxDisplayCount  1    //don't show if called by app
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>