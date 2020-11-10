<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	
	/* core inclusions */
	include_once("../ep_library/initialise.php");

	include_once(EPABSPATH."/include/classes/service.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/voucher.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/userFavourite.class.php");	
	
	exit;

	$result = Service::sendSMTPMessage('gav@entice.com.au','Small','info@smallideas.com.au','testing','Some content in here',EPABSPATH.'/gift-vouchers/SmallIdeas-201812082325-michaela_bautistahotmailcom.pdf');
		echo $result; 
		exit;
		
		

$sendToArr[0] = 'gav@entice.com.au';
	$em_parts = explode('@',$sendToArr[0]);
				if(isset($em_parts[1]))
					$emailDomain = $em_parts[1];
//		echo $emailDomain;		

$date = date('Y-m-d',strtotime('-1 month'));
echo $date;

	exit;
	
	$content = 'Email content goes in here.<br>New line.';
	
	$useSMTP = false;
	$domains_parts = explode(',',USE_SMTP_SERVER);
	print_r($domains_parts);
		foreach($domains_parts as $aDomain){
			if($aDomain == $emailDomain){
				$useSMTP = true;
			}
		}
	
		if($useSMTP){
			$result = Service::sendSMTPMessage('gav@entice.com.au','SmallIdeas',SMTP_USERNAME,"Small Ideas login",$content);
			
		} 
		
	
	
	echo $result;

?>