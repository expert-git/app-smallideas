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
	include_once(EPABSPATH."/include/classes/voucher.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');


	$pageTemplate = new Template(EPABSPATH.'/templates/viewNearMe.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//get categories
	//if(!isset($_GET['id']) && !isset($_GET['regionid'])){
	//	header("Location: /categories.html");
	//	exit;
	//}

// 	//get category details
// 	$categoryId = null;
// 	if(isset($_GET['id'])){
// 		$categoryId = Service::cleanNumeric($_GET['id']);
// 		$categoryObj = DAL_Category::GetById($categoryId);
// 	} else {
// 		$categoryObj = null;
// 	}

// 	//get region if set
// 	if(isset($_GET['regionid'])){
// 		$regionObj = DAL_Region::GetById(Service::cleanNumeric($_GET['regionid']));
// 	} else {
// 		$regionObj = null;
// 	}

// 	//if in region, and in a category with child categories, get those vouchers
// 	$categoryIds = $categoryId;
// 	if($regionObj && $categoryObj && $categoryObj->hasChildren){
// 		$categoryIds .= ',';
// 		$childCategoryObjArr = DAL_Category::GetAllForParentId($categoryObj->id);
// 		foreach($childCategoryObjArr as $catObj){
// 			$categoryIds .= $catObj->id.',';
// 		}
// 		$categoryIds = substr($categoryIds,0,-1); //take off last comma
// 	}
// //	echo $categoryIds; exit;

	//get 

	//get backlink
	if(isset($_GET['parent'])){
		switch($_GET['parent']){
			case 'browse':
				$backlink = '/categories.html';
				break;
			case 'browsecat':
				$backlink = '/categories.html?id='.$_GET["parentid"].'&parent=browse';
				break;
			case 'regionscat':
				$backlink = '/categories.html?regionid='.$_GET["regionid"].'&parent=regions';
				break;
			case 'regions':  //visit ballarat etc via regions
				$backlink = '/regions.html';
				break;
		}		
	}

	//set template vars
//	$template->backlink = $backlink;
	$template->title = "Small Ideas | Vouchers near me";
	$template->heading = "Vouchers near me";
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'nearme';
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '<script src="/js/nearme.js?v2.22" type="text/javascript"></script>';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>