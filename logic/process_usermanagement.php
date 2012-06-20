<?php

include_once '../configuration.inc.php';

require PATH_CLASSES .'cl_customizing.php';
require PATH_CLASSES .'cl_customer.php';
require PATH_CLASSES .'cl_language.php';

if(session_id() == '') {
	session_start();
}

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once PATH_INCLUDES .'database_tables.php';
//include_once PATH_LANGUAGES .'DE.inc.php';
include_once PATH_FUNCTIONS .'user_management.php';

if(!isset($language_id)) {
	// check if language was handed over
	if(isset($_POST['language_id'])) {
		$language_id = language::ISOTointernal($_POST['language_id']);
		if($language_id == null) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
	}
	else {
		$language_id = language::ISOTointernal( language::getBrowserLanguage() );
	}
}

include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';

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
				$_SESSION['customer_id'] = $user_information['customer_id'];
				echo 'true';
			}	
		}
		else {
			echo WARNING_WRONG_CREDENTIALS;
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
	
	// check if user is still logged in	
	case 'isLoggedIn':
		if(customer::isLoggedIn(session_id()) == true) {
			echo 'true';
		}
		else {
			echo 'false';
		}
		
		break;
}

?>