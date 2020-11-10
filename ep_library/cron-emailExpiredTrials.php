<?php

	// sends reminder email to all trial accounts expiring today
	// cron at mid-morning daily

	/* core inclusions */
	include_once("../ep_library/initialise.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");	
	include_once(EPABSPATH."/include/classes/template.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	//get trial accounts expiring today
	$userObjArr = DAL_User::GetExpiringTrialAccounts();
//	print_r($userObjArr);
	if($userObjArr){
		foreach($userObjArr as $userObj){

			//send email to user								
			$emailContent = new Template(EPABSPATH.'/templates/emailTrialExpiry.tmpl.php');						
			$subject = "Small Ideas trial";
			echo "Emailing {$userObj->email}\n";
			$result = Service::sendMessage(array($userObj->email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());

		}
	}





?>