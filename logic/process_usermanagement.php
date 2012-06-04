<?php

require '../includes/classes/cl_customizing.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';
include_once '../functions/user_management.php';



$action = $_POST['action'];

switch($action) {

	case 'login_customer':
		$email = $_POST['email'];
		$password = $_POST['password'];	
		
		$user_information = db_user_check_credentials( $email, $password );
		
		if( $user_information != false) {
			
			$is_logged_in = db_user_is_logged_in(session_id());
			if($is_logged_in == true) {
				echo WARNING_STILL_LOGGED_IN;	
			}
			else {
				db_customer_login( $user_information['customer_id'], session_id() );
			}	
		}
		
	break;
	
	case 'login_backend':
		$email = $_POST['email'];
		$password = $_POST['password'];
	
		$user_information = db_backend_user_check_credentials( $email, $password );
	
		if( $user_information != false) {
				
			$is_logged_in = db_backend_user_is_logged_in(session_id());
			if($is_logged_in == true) {
				echo WARNING_STILL_LOGGED_IN;
			}
			else {
				db_backend_login( $user_information['backend_user_id'], session_id() );
			}
		}
	
		break;
	
	case 'logout_customer':
		
		db_user_customer_logout(session_id());
		session_destroy();
	
		break;
		
	case 'logout_backend':
	
		db_user_backend_logout(session_id());
		session_destroy();
	
		break;
	
}

?>