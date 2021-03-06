<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

include_once(EPABSPATH."/include/classes/DAL/voucherRegion.class.php");
 
class BO_Voucher {
	
	private $data;
	
	function __construct($resultset = false){
		$this->data = ($resultset === false) ? array() : $resultset;
		$this->extract($resultset);		
	}
	
	public function __get($key) {		
        if (!array_key_exists($key,$this->data)) {
			if($key == 'regions'){
				$regionObjArr = DAL_VoucherRegion::GetAllForVoucherId($this->id);
//				print_r($regionObjArr);
				$this->regions = $regionObjArr;
//				print_($this->regions);
				return $this->data[$key];
			} else {
//				echo 's';
             	return false;
			 }
            // throw new Exception("Invalid member $key.");
        } else {
             return $this->data[$key];
        }
    }
	
	function __set( $key, $val ) {
		/* validation here 
		switch($key) {
			case 'b':
				if( !is_numeric( $val ) ) throw new Exception("Variable $b must be numeric");
				break;
		} */		
		$this->data[$key] = $val;
	}
	
	public function extract($source)
	{
		if($source){
			foreach ($source as $property => $value){
				$this->data[$property] = $value;
			}
		}
	}
	
	public function save(){
		if($this->id){
			return DAL_Voucher::Update($this);
		} else {
			return DAL_Voucher::Create($this);
		}
	}
}


?>