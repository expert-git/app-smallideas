<?php 

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

include_once ('DAL/category.class.php');


/**
 * 
 * 
 */
class X_Category
{
	
	/* generate heirarchical array of categories */
	public static function GetAll(){

		$objArr = DAL_Category::GetAll();

		return $objArr;

	}

	
}

?>