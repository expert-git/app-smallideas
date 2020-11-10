<?php

//called every 5min by uptimerobot to check if db still running

	/* core inclusions */
	include_once("../ep_library/initialise.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/region.class.php");	
	
	$obj = DAL_Region::GetById(1);
	if($obj){
		echo $obj->name;
	} else {
		echo 'Database issue.';
	}

?>