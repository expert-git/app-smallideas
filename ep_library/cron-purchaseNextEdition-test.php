<?php
	
	/* CRON JOB RUN at the end of December, or january to encourage existing customers to re-purchase */
	/* run at 10am - ish */

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
	
	/* core inclusions */
	include_once("./initialise.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/template.class.php");
	include_once(EPABSPATH."/include/classes/user.class.php");
	
	//get all users
	$userObj = DAL_User::GetById(50);

	//which edition to sell - if DEC, then next year's otherwise current year
	$edition = (date('m') >= 8) ? date('Y',strtotime("+1year")) : date('Y');

//	foreach($userObjArr as $userObj){
		//check if latest edition user has is less than latest available
		if($userObj->latestEdition && $userObj->latestEdition < $edition && $userObj->isTrialAccount == 0 ){
			
			//set max 20s per email
			$success = set_time_limit (20);

			//send email to user								
			$emailContent = new Template(EPABSPATH.'/templates/emailPurchaseNextEdition.tmpl.php');			
			$emailContent->edition = $edition;
			$subject = "Small Ideas $edition available now";
			echo "Emailing {$userObj->email}\n";
			$result = Service::sendMessage(array($userObj->email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());
		//print_r($userObj);

		}
//	 }

	 
  
?>