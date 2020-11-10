<?php
	
	/* CRON JOB RUN DAILY FOR CLEANUP TASKS */
	/* Needs to run early AM each day */

	
	/* core inclusions */
	include_once("./initialise.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/user.class.php");
	include_once(EPABSPATH."/include/classes/DAL/authToken.class.php");
	
	/*
	 * remove expired password reset urls 
	 */
	
	$userObjArr = DAL_User::GetAll();
	if($userObjArr){
		foreach($userObjArr as $userObj){
			 if($userObj->passwordResetExpiry < date('Y-m-d H:i:s')){
				 echo "UserId: {$userObj->id} \n";
				 $userObj->passwordResetExpiry = NULL;
				 $userObj->passwordResetUrl = NULL;
			 }
			 DAL_User::Update($userObj);
		 }
	 }
	 
	 
 	/*
 	 * send email to accounts that are expiring in x days
 	 */
	
 	$sendDaysBeforeExpiry = 3;
 	$userObjArr = DAL_User::GetExpiringInDays($sendDaysBeforeExpiry);
	
 	$subject = 'REMINDER';
 	$emailContent = new Template(EPABSPATH.'/templates/emailSubscriptionRenewal.tmpl.php');
 	$emailContent->days = $sendDaysBeforeExpiry;
		
 	if($userObjArr){
 		foreach($userObjArr as $userObj){
 			//send email				
 			
 				$result = Service::sendMessage(array($userObj->email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		 
 				echo $result;
 			
 		 }
 	 }
	 
	 /* 
	  * Remove expired cookies
	  */
	 
	 DAL_AuthToken::DeleteExpired();
	 echo "\nExpired AuthTokens Deleted\n\n";
  
?>