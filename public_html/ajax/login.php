<?php

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	
	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/auth.class.php");
	include_once(EPABSPATH."/include/classes/user.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	
	if(isset($_GET['mode']) && $_GET['mode'] == 'reset'){

		X_Auth::sendPasswordResetLink($_POST['email']);  				
		echo json_encode(array('success'=>1));
	
	//
	// Set password
	//
	
	} elseif(isset($_GET['mode']) && $_GET['mode'] == 'setpassword'){
//		echo 'a';
		$result = X_Auth::setPassword($_POST['password'],$_POST['url']);
		if($result){		
			echo json_encode(array('success'=>1));
		} else {
			echo json_encode(array('success'=>0));
		}

	//
	// Logout
	//

	} elseif(isset($_GET['mode']) && $_GET['mode'] == 'logout'){
		
		//clear session				
		X_Auth::logout();
		echo json_encode(array('success'=>1));
		exit;


	} 

	
?>