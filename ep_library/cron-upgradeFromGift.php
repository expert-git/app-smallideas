<?php
	
	/* CRON JOB RUN daily to encourage people to buy the subscription */
	/* run at end DEC 2018 */
	/* can be disabled in 2019 when no more people are non-subscription.
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
	$userObjArr = DAL_User::GetAll();

	//which edition to sell - if DEC, then next year's otherwise current year
	//$edition = (date('m') >= 8) ? date('Y',strtotime("+1year")) : date('Y');


	foreach($userObjArr as $userObj){
		//send to user on day of expiry
		if($userObj->isSubscription != 1 && $userObj->isTrialAccount == 0 && $userObj->accountExpiry == date('Y-m-d')){
			
			//set max 20s per email
			$success = set_time_limit (20);

			//send email to user								
			$emailContent = new Template(EPABSPATH.'/templates/emailUpgradeFromGift.tmpl.php');			
			//$emailContent->edition = $edition;
			$subject = "Continue your Small Ideas subscription";
			echo "Emailing {$userObj->email}\n";
			$result = Service::sendMessage(array($userObj->email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());
		//print_r($userObj);

		}
	 }

	 
  
?>