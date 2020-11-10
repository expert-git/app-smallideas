<?php

class DAL_PDO extends PDO {
	
    public function __construct()
    {        
		$dns = 'mysql:host='.EPDB_HOST.((null!==EPDB_PORT&&(EPDB_PORT!=='')) ? (';port='.EPDB_PORT) : '').';dbname='.EPDB_NAME;		
		$username = EPDB_USER;
		$password = EPDB_PASSWORD;
        parent::__construct($dns, $username, $password);
    }		
	
}

?>