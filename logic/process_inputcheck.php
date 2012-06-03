<?php

include '../includes/languages/DE.inc.php';

require '../includes/classes/cl_customizing.php';

session_start();

$action = $_POST['action'];

switch($action) {
	case 'check_password':
		$password_input = $_POST['password'];
		
		// check password length
		if(strlen($password_input) < $_SESSION['customizing']->getCustomizingValue('min_password_length')) {
			echo WARNING_SHORT_PASSWORD;
		}
		
	break;
	
	case 'get_message_mandatory_not_filled':
		echo WARNING_FILL_ALL_MANDATORY_FIELDS;
	break;
}

?>