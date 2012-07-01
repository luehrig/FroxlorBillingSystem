<?php

session_start();

include '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once PATH_INCLUDES .'database_tables.php';

$customizing = new customizing( language::ISOTointernal(language::getBrowserLanguage()) );
$_SESSION['customizing'] = $customizing;


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
	case 'check_passwordlength':
		$password_input = $_POST['password'];

		// check password length
		if(strlen($password_input) < $_SESSION['customizing']->getCustomizingValue('min_password_length')) {
			echo 'div id="short_password">'. WARNING_SHORT_PASSWORD .'</div>';
		}

		break;

	case 'get_message_mandatory_not_filled':
		echo '<div id="mandatory_fields">'. WARNING_FILL_ALL_MANDATORY_FIELDS .'</div>';
		break;

	case 'get_message_passwords_not_matching':
		echo '<div id="passwords_not_matching">'. WARNING_PASSWORD_NOT_MATCHING .'</div>';
		break;

	case 'get_message_invalid_telephone':
		echo '<div id="invalid_telephone">'. WARNING_INVALID_TELEPHONE .'</div>';
		break;

	case 'get_message_invalid_fax':
		echo '<div id="invalid_fax">'. WARNING_INVALID_FAX .'</div>';
		break;

	case 'get_message_invalid_email':
		echo '<div id="invalid_email_message">'. WARNING_INVALID_EMAIL .'</div>';
		break;
}

?>