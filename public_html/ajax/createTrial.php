<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
	
	$http_origin = $_SERVER['HTTP_ORIGIN'];
	if ($http_origin == "http://demo4.easypeas.com.au" || $http_origin == "http://www.smallideas.com.au" || $http_origin == "https://smallideas.com.au" )
	{  
	    header("Access-Control-Allow-Origin: $http_origin");
	}

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	
	/* database classes required for page */		
	include_once(EPABSPATH."/include/classes/user.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userEdition.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	//print_r($_POST); exit;
	
	$email = (isset($_POST['email'])) ? Service::cleanEmail($_POST['email']) : '';
	$firstname = (isset($_POST['firstname'])) ? Service::cleanTitle($_POST['firstname']) : '';
	$lastname = (isset($_POST['lastname'])) ? Service::cleanTitle($_POST['lastname']) : '';
	
	//validate email
	if(strpos($email,'@')===false || strpos($email,'.')===false){
		echo json_encode(array('success'=>0,'reason'=>'email'));
		exit;
	}
	
	//validate name
	if(strlen($firstname) < 2 || strlen($lastname) < 2){
		echo json_encode(array('success'=>0,'reason'=>'name'));
		exit;
	}
	
//		echo 'd'; exit;
	if($email && $firstname && $lastname){

		$result = X_User::CreateTrial($email,$firstname,$lastname);

		if($result > 0){
			//all good!
			echo json_encode(array('success'=>1));	
			exit;		
		} else if($result == EMAIL){
			//couldn't update
			echo json_encode(array('success'=>0,'reason'=>'email'));
			exit;
		} else {
			//couldn't update
			echo json_encode(array('success'=>0,'reason'=>'unknown'));		
			exit;
		}

	} else {
		echo json_encode(array('success'=>0));
		exit;
	}



	echo json_encode(array('success'=>0));
	
?>