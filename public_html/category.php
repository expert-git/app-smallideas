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
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");
	include_once(EPABSPATH."/include/classes/voucher.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');


	$pageTemplate = new Template(EPABSPATH.'/templates/viewCategory.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//get categories
	if(!isset($_GET['id']) && !isset($_GET['regionid'])){
		header("Location: /categories.html");
		exit;
	}

	//get category details
	$categoryId = null;
	if(isset($_GET['id'])){
		$categoryId = Service::cleanNumeric($_GET['id']);
		$categoryObj = DAL_Category::GetById($categoryId);
	} else {
		$categoryObj = null;
	}

	//get region if set
	if(isset($_GET['regionid'])){
		$regionObj = DAL_Region::GetById(Service::cleanNumeric($_GET['regionid']));
	} else {
		$regionObj = null;
	}

	//if in region, and in a category with child categories, get those vouchers
	$categoryIds = $categoryId;
	if($regionObj && $categoryObj && $categoryObj->hasChildren){
		$categoryIds .= ',';
		$childCategoryObjArr = DAL_Category::GetAllForParentId($categoryObj->id);
		foreach($childCategoryObjArr as $catObj){
			$categoryIds .= $catObj->id.',';
		}
		$categoryIds = substr($categoryIds,0,-1); //take off last comma
	}
//	echo $categoryIds; exit;

	//get vouchers
	if($regionObj && $categoryObj){
		//region and category
		$voucherObjArr = DAL_Voucher::GetAllInCategoriesAndRegionForEdition(date('Y'),$categoryIds,$regionObj->id);
	} elseif($regionObj){
		//region only (ie 'Visit Ballarat' etc)		
		$voucherObjArr = X_Voucher::GetAllInRegionForEdition(date('Y'),$regionObj->id);
		if($_SERVER['REMOTE_ADDR'] == '210.84.63.195'){
//			print_r($voucherObjArr);exit;
		}
	} else {
		//category only
		$voucherObjArr = DAL_Voucher::GetAllInCategoryForEdition(date('Y'),$categoryId);
	}

	//get vouchers used by user
	$userObj = DAL_User::GetById($_SESSION['userid']);
	$userHistoryArr = DAL_UserHistory::GetAllForUser($_SESSION['userid'],$userObj->lastRenewed);
	
	//check hidden vouchers
	$userHiddenObjArr = DAL_UserHidden::GetAllForUser($_SESSION['userid']);
	$userHiddenArr = array();
	if($userHiddenObjArr){
		foreach($userHiddenObjArr as $uhObj){
			$userHiddenArr[$uhObj->id] = 1;
		}
	}

	//restructure array
	$userHistoryObjArr = array();
	foreach($userHistoryArr as $uo){
		$userHistoryObjArr[$uo->voucherId] = $uo;
	}
	//print_r($userHistoryObjArr); exit;

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

	
	//set heading
	$region = ($regionObj) ? "{$regionObj->name} > " : "";
	$template->heading = ($categoryObj) ? $region.$categoryObj->name : str_replace(' >','',$region);
	

	//set template vars
	$template->backlink = $backlink;
	$template->voucherObjArr = $voucherObjArr;
	$template->categoryObj = $categoryObj;
	$template->userHiddenArr = $userHiddenArr;
	$template->userHistoryObjArr = $userHistoryObjArr;
	$template->title = ($categoryObj) ? "Small Ideas | ".$categoryObj->name : "Small Ideas | ".$regionObj->name;
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'categories';
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '
	
									';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>