<?php

class DAL_WP_PDO extends PDO {
	
    public function __construct()
    {        
		$dns = 'mysql:host='.EPDB_HOST.((null!==EPDB_PORT&&(EPDB_PORT!=='')) ? (';port='.EPDB_PORT) : '').';dbname='.WPDB_NAME;		
		$username = WPDB_USER;
		$password = WPDB_PASSWORD;
        parent::__construct($dns, $username, $password);
    }		
	
}

?>