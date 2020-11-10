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
	include_once(EPABSPATH."/include/classes/DAL/category.class.php");
	include_once(EPABSPATH."/include/classes/DAL/region.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');


	$pageTemplate = new Template(EPABSPATH.'/templates/viewCategories.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	
	//get user, so can work out state
	$userObj = DAL_User::GetById($_SESSION['userid']);

	//get categories
	$categoryId = (isset($_GET['id'])) ? Service::cleanNumeric($_GET['id']) : 0;
	$categoryObjArr = DAL_Category::GetAllForParentId($categoryId,$userObj->state);

	//get parent category info if required
	if($categoryId){
		$categoryObj = DAL_Category::GetById($categoryId);		
	}

	//get region if set
	if(isset($_GET['regionid'])){
		$regionObj = DAL_Region::GetById(Service::cleanNumeric($_GET['regionid']));
	} else {
		$regionObj = null;
		
		//get 'visit NSW' regions etc
		$regionObjArr = DAL_Region::GetVisitRegions($userObj->state);
//		print_r($regionObjArr); exit;
	}

	//set heading
	$region = (isset($regionObj)) ? "{$regionObj->name} > " : "";
	$template->heading = (isset($categoryObj)) ? $region.$categoryObj->name : "Browse vouchers";
	if(isset($regionObj) && !isset($categoryObj)){
		$template->heading = "Browse {$regionObj->name} Vouchers";
	}

	//get backlink
	if(isset($_GET['parent'])){
		switch($_GET['parent']){
			case 'browse':
				$backlink = '/categories.html';
				break;
			case 'regions':
				$backlink = '/regions.html';
				break;
		}		
	}

	//set template vars
	$template->backlink = $backlink;
	$template->categoryObjArr = $categoryObjArr;
	$template->title = "Small Ideas | ".$template->heading;	
	$template->regionId = ($regionObj) ? $regionObj->id : '';
	$template->categoryId = $categoryId;
	$template->regionObjArr = ($regionObjArr) ? $regionObjArr : null;
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'categories';
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>