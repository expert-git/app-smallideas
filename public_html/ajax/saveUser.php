<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	
	/* database classes required for page */		
	include_once(EPABSPATH."/include/classes/user.class.php");
	include_once(EPABSPATH."/include/classes/DAL/userEdition.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");


	if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
	
		if(isset($_POST) && count($_POST)>1){

			$result = X_User::Update($_POST);

			if($result > 0){
				//all good!
				echo json_encode(array('success'=>1));			
			} else if($result == PASSWORD){
				//couldn't update
				echo json_encode(array('success'=>0,'reason'=>'password'));
			} else if($result == EMAIL){
				//couldn't update
				echo json_encode(array('success'=>0,'reason'=>'email'));
			} else {
				//couldn't update
				echo json_encode(array('success'=>0,'reason'=>'unknown'));		
			}

		} else {
			echo json_encode(array('success'=>0));
			exit;
		}
		exit;
	}

	echo json_encode(array('success'=>0));
	
?>