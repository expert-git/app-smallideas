<?php

/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

//	error_reporting(E_ALL);
//	ini_set('display_errors', 1);

	// Set the max lifetime
	ini_set("session.gc_maxlifetime", 604800); //7days
    // Set the session cookie to timout
    ini_set("session.cookie_lifetime", 604800);  //7days
		
	/* SITE CONFIG */
	$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : 'smallideas.com.au'; //needed for cron		
	
	/* site specific */	
	switch($host){
		
		case 'app.smallideas.dev':
		case 'www.smallideas.dev':  //local dev	
		case 'smallideas.dev':
			/* reports to send to */
			define('ADMIN_EMAIL', 'gav@entice.com.au');
			define('APPDOMAIN','https://app.smallideas.dev');
			define('COOKIEDOMAIN','app.smallideas.dev');
			define('EPDB_NAME', 'smallideas');
			define('EPDB_USER', 'root');  //ampps uses root			
			define('EPDB_PASSWORD', 'mysql');			
			define('EPDB_HOST', 'localhost');
			define('EPDB_PORT', '8889');			
			break;
		case 'demo4.easypeas.com.au':	//staging dev	
		case 'app.demo4.easypeas.com.au':	
			/* reports to send to */
			define('ADMIN_EMAIL', 'gav@entice.com.au');
			define('APPDOMAIN','http://app.demo4.easypeas.com.au');
			define('COOKIEDOMAIN','app.demo4.easypeas.com.au');
			define('EPDB_NAME', 'demo4ep_app');
			define('EPDB_USER', 'demo4ep_usr');
			define('EPDB_PASSWORD', 'SJGasJDsj333');
			define('EPDB_HOST', 'localhost');
			define('EPDB_PORT', '3306');			
			break;
		
		default:  //LIVE
			/* reports to send to */
			define('ADMIN_EMAIL', 'gav@entice.com.au');
			define('APPDOMAIN','https://app.smallideas.com.au');
			define('COOKIEDOMAIN','app.smallideas.com.au');			
			define('EPDB_NAME', 'smallid4_ap');
			define('EPDB_USER', 'smallid4_apusr');
			define('EPDB_PASSWORD', 'G0)sg9gs2@%#sg4js');
			define('EPDB_HOST', 'localhost');
			define('EPDB_PORT', '3306');			
			break;
	}
	
	/* WP to connect for stats */
	define('WPDB_NAME', 'smallid4_jjj');
	define('WPDB_USER', 'smallid4_usr');
	define('WPDB_PASSWORD', 'DFTH88%gg22');

	
	
	
	/* to secure sessions */
	define('SESSION_SALT','ASfg(202a87*2h)S');
	

	/* sendgrid */
	define('SENDGRID_API_KEY','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');
	define('EMAIL_FROM','info@smallideas.com.au');
	define('EMAIL_FROMNAME','Small Ideas');

	/* google maps */
	//define('GOOGLE_API','AIzaSyB1v_UnzwnREXJLRsjNw7X8ycsPa4C3Km0');  //mygui..
	define('GOOGLE_API','AIzaSyCVHl0uF7hLvy76HaoJU64VRZTqY9fcN1A');  //smallideas

	/* smtp settings */
	define('USE_SMTP_SERVER','yahoo.com,yahoo.com.au,yahoo.com.hk,ymail.com,yahoo.co.uk,yahoo.co.nz,y7mail.com');  //comma separate list for domains that should receive an email via SMTP instead of Sendgrid. Check domain issues in Sendgrid > 
	define('SMTP_HOST','ssl://smtp.zoho.com');
	define('SMTP_PORT','465');
	define('SMTP_USERNAME','info@smallideas.com.au');
	define('SMTP_PASSWORD','Chapter3624');
	
	/* define characters */
	define('NO',0);
	define('YES',1);
	define('NOTSET',-1);	
	define('ADMIN',1);
	define('EMAIL',-2);
	define('EDITION',-3);
	define('TRIALEXPIRED',-4);
	define('EXPIRED',-5);
	define('PASSWORD',-1);
	
	define('TRIAL_DAYS',5);  //length of the trial

	/** Absolute path to the WordPress directory. */
	if ( !defined('EPABSPATH') )
		define('EPABSPATH', dirname(__FILE__));
			
	define('WEBPATH',$_SERVER['DOCUMENT_ROOT']);	
	
	/* set server timezone */
	date_default_timezone_set('Australia/Melbourne');
				
	/* Stripe API configuration */
	define('STRIPE_API_KEY', 'sk_live_x2t9F7NeehMmkJ6c3rdgeIov'); 
	define('STRIPE_PUBLISHABLE_KEY', 'pk_live_SIBB12t4l4oxxpyj1thPk720'); 
	

?>