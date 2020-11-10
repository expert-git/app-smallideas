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
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);
	
	//get user, so can work out state
	$userObj = DAL_User::GetById($_SESSION['userid']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');

	$pageTemplate = new Template(EPABSPATH.'/templates/viewSearch.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template

	//get search results
	if(isset($_GET['s'])){
		//search..
		$search = Service::cleanString($_GET['s']);
		$searchSQL = Service::createSqlSearchString($search);
		$edition = date('Y');
		$vObjArr = DAL_Voucher::GetAllSearch($searchSQL,$userObj->state);
		
		//check hidden vouchers
		$userHiddenObjArr = DAL_UserHidden::GetAllForUser($_SESSION['userid']);
		$userHiddenArr = array();
		if($userHiddenObjArr){
			foreach($userHiddenObjArr as $uhObj){
				$userHiddenArr[$uhObj->id] = 1;
			}
		}
		$voucherObjArr = array();
		foreach($vObjArr as $vObj){
			if(!isset($userHiddenArr[$vObj->id])){
				$voucherObjArr[] = $vObj;
			}
		}

		$template->heading = "Result for $search";
	} else {
		$search = '';
		$voucherObjArr = null;
		$template->heading = "Search";
	}
	
	//get vouchers used by user
	$userObj = DAL_User::GetById($_SESSION['userid']);
	$userHistoryArr = DAL_UserHistory::GetAllForUser($_SESSION['userid'],$userObj->lastRenewed);

	//restructure array
	$userHistoryObjArr = array();
	foreach($userHistoryArr as $uo){
		$userHistoryObjArr[$uo->voucherId] = $uo;
	}

	//set template vars
	$template->backlink = "/";
	$template->title = "Small Ideas | Search";
	$template->isAdmin = $isAdmin;
	$template->search = $search;
	$template->bodyClass = 'search';
	$template->userHistoryObjArr = $userHistoryObjArr;
	$template->voucherObjArr = $voucherObjArr;
	$template->pagelevelCSS = '';	
	$template->pagelevelScripts = '';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>