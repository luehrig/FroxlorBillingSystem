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
	case 'check_password':
		$password_input = $_POST['password'];
		
		// check password length
		if(strlen($password_input) < $_SESSION['customizing']->getCustomizingValue('min_password_length')) {
			echo WARNING_SHORT_PASSWORD;
		}
		
	break;
	
	case 'check_email':
		$email = $_POST['email'];
		
		// check validation of email
		if(!$valid_email = validEmail($email)){
			echo WARNING_INVALID_EMAIL_ADDRESS;
		}
		
		break;
		
// 	case 'check_phone_no':
// 		$phone_no = $_POST['phone_no'];
// 		$reg_expr = '/[(+49)0]{1}\d+\s?[\/-]?\s?\d+/';
// 		if (!preg_match($reg_expr, $phone_no)){
// 			echo WARNING_INVALID_PHONE_NO;
// 		}
// 		break;
	
// 	case 'get_message_mandatory_not_filled':
// 		echo WARNING_FILL_ALL_MANDATORY_FIELDS;
// 	break;
}

/**
 Validate an email address.
 Provide email address (raw input)
 Returns true if the email address has the email
 address format and the domain exists.
 */
function validEmail($email)
{
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex)
	{
		$isValid = false;
	}
	else
	{
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64)
		{
			// local part length exceeded
			$isValid = false;
		}
		else if ($domainLen < 1 || $domainLen > 255)
		{
			// domain part length exceeded
			$isValid = false;
		}
		else if ($local[0] == '.' || $local[$localLen-1] == '.')
		{
			// local part starts or ends with '.'
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $local))
		{
			// local part has two consecutive dots
			$isValid = false;
		}
		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		{
			// character not valid in domain part
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $domain))
		{
			// domain part has two consecutive dots
			$isValid = false;
		}
		else if
		(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\","",$local)))
		{
			// character not valid in local part unless
			// local part is quoted
			if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\","",$local)))
			{
				$isValid = false;
			}
		}
		if ($isValid && !(checkdnsrr($domain,"MX") ||
				↪checkdnsrr($domain,"A")))
		{
		// domain not found in DNS
			$isValid = false;
		}
		}
			return $isValid;
}

?>