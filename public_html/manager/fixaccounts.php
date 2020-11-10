<?php

/* core inclusions */
include_once("../../ep_library/initialise.php");
include_once(EPABSPATH."/include/classes/template.class.php");

/* database classes required for page */
include_once(EPABSPATH."/include/classes/DAL/user.class.php");

exit;


$file = './fixaccounts-dec2.csv';

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}
 

		/*	 	 
		 * Get all user accounts
		 */
		function GetAll() {
			try
			{		//exit;
				$oDbConnection = new DAL_PDO();			
				$sqlStatement = 'SELECT * FROM `user` WHERE accountExpiry > "2018-11-30" && accountExpiry < "2019-01-01"';
				$sth = $oDbConnection->prepare($sqlStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));			
				$sth->execute();
				$rsResults = $sth->fetchAll(PDO::FETCH_ASSOC);
//					print_r($rsResults);
				if($sth->rowCount()>0){ 
					foreach($rsResults as $aResult){
						$objArr[] = new BO_User($aResult);
					}
					return $objArr;
				}

			}
			catch (Exception $ex)
			{			
				throw $ex;	
			}
		}






 
$csv = readCSV($file);
//echo '<pre>';print_r($csv);echo '</pre>';




	

$userObjArr = GetAll();
//print_r($userObjArr);
//echo count($userObjArr);

$accountIssueArr = array();
foreach($userObjArr as $userObj){
	foreach($csv as $c){
		if($c[1]==$userObj->email){
			$userObj->purchase = $c[0];
			$accountIssueArr[] = $userObj;
		}
		//echo $c[1]; exit;
	}	
}

echo count($accountIssueArr);
print_r($accountIssueArr);

foreach($accountIssueArr as $uObj){
	$uObj->accountExpiry = '2019-12-30';
//	$uObj->save();
//	exit;
}

?>

