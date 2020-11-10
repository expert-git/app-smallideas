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
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userFavourite.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userHidden.class.php");	

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	//allow if link from neatideas pdf
	if(isset($_GET['insec']) && $_GET['insec']=='neatideas'){
		$_SESSION['allow-insecure'] = 'neatideas';
	} else {
		unset($_SESSION['allow-insecure']);
		//regular login check
		X_Auth::Login();
	}


	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');


	$pageTemplate = new Template(EPABSPATH.'/templates/viewVoucher.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	
				

	//get categories
	if(!isset($_GET['id'])){
		header("Location: /categories.html");
		exit;
	}

	//get voucher details
	if(isset($_GET['id'])){
		$voucherId = Service::cleanNumeric($_GET['id']);		
		$voucherObj = DAL_Voucher::GetById($voucherId);		
	}
	
	//check if user has access to this edition
	$hasAccess = false;
	$yearnow = date('Y');
//	echo $_SESSION['userid']." - ".$yearnow;exit;
//	$userEditionObj = DAL_UserEdition::GetForUserYear($_SESSION['userid'],$yearnow);
//	if($userEditionObj && $userEditionObj->edition == $yearnow){
		$hasAccess = true;
	//}

	//check if is a userfavourite
	$userFavouriteObj = (isset($_SESSION['allow-insecure'])) ? null : DAL_UserFavourite::GetByUserAndVoucher($_SESSION['userid'],$voucherId);
	$userHiddenObj = (isset($_SESSION['allow-insecure'])) ? null : DAL_UserHidden::GetByUserAndVoucher($_SESSION['userid'],$voucherId);
	$userObj = (isset($_SESSION['allow-insecure'])) ? null : DAL_User::GetById($_SESSION['userid']);

	if(!isset($_SESSION['allow-insecure'])){
		//check if user has already redeemed
		if($voucherObj->allowMonthlyUse == 1){
	//		echo 'a';
			$existingHistoryObj = DAL_UserHistory::GetByMonthlyRecurring($_SESSION['userid'],$voucherObj->id);
	//		print_r($existingHistoryObj); exit;
		} else if($voucherObj->allowMonthlyUse == 2){ //WEEKLY
			$existingHistoryObj = DAL_UserHistory::GetByWeeklyRecurring($_SESSION['userid'],$voucherObj->id);
		} else {
			$existingHistoryObj = DAL_UserHistory::GetByUserAndVoucher($_SESSION['userid'],$voucherObj->id,$userObj->lastRenewed);
		}
	}
	// if($_SERVER['REMOTE_ADDR']=='1.152.106.55'){
// 		print_r($userObj);
// 		print_r($_SESSION);
// 		print_r($voucherObj);
// 	}

	//set backlink
	if(isset($_GET['parent']) && (isset($_GET['parentid']) || $_GET['parent']=='favourites' || $_GET['parent']=='hidden' || $_GET['parent']=='nearme' || isset($_GET['parentregionid']))){
		switch($_GET['parent']){
			case "browsecat":  //came via 'browse vouchers'

				if(isset($_GET['parentregionid'])){  //via visit ballarat etc under browse
					$backlink = "/category.html?regionid={$_GET['parentregionid']}&parent=browse";					
				} else {
					$backlink = "/category.html?id={$_GET['parentid']}&parent=browse";
				}				
				break;
			case "browsecatcat": //came via Play's multiple levels
				$parentcatid = (isset($_GET['parentcatid'])) ? $_GET['parentcatid'] : 0;				
				$backlink = "/category.html?id={$_GET['parentid']}&parent=browsecat&parentid={$parentcatid}";
				break;
			case "regionscatv": //came via region
				if(isset($_GET['parentregionid'])){				
					$backlink = "/category.html?id={$_GET['parentid']}&regionid={$_GET['parentregionid']}&parent=regionscat";
				} else {
					$backlink = "/";
				}
				break;
			case "regionsv": //within visit ballart etc via region							
				$backlink = "/category.html?regionid={$_GET['parentid']}&parent=regions";
				break;
			case "search":
				$backlink = "/search.html?s={$_GET['parentid']}";
				break;
			case "favourites":
				$backlink = "/favourites.html";
				break;
			case "hidden":
				$backlink = "/hidden.html"; 
				break;
			case "nearme":
				$backlink = "/nearme.html";
				break;
		}
	}
	if(isset($_GET['pos'])){
		$backlink .= '#'.$_GET['pos'];
	}

	//set template vars
	$template->backlink = $backlink;
	$template->voucherObj = $voucherObj;	
	$template->userFavouriteObj = $userFavouriteObj;
	$template->userHiddenObj = $userHiddenObj;		
	$template->hasAccess = $hasAccess;
	$template->existingHistoryObj = $existingHistoryObj;
	$template->heading = $voucherObj->businessName;
	$template->title = "Small Ideas | ".$voucherObj->businessName;
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'voucher';
	$template->pagelevelCSS = '<link type="text/css" rel="stylesheet" href="/css/featherlight.css" />';	
	$template->pagelevelScripts = '<script src="/js/featherlight.js" type="text/javascript" charset="utf-8"></script>';

	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>