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

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewContact.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template



	//set template vars
	$template->heading = "Contact";
	$template->title = "Small Ideas | Contact";
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'faq';
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>