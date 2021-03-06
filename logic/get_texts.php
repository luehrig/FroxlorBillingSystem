<?php

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_product.php';

if(session_id() == '') {
	session_start();
}

require_once PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';


if(!isset($action)) {
	$action = $_POST['action'];
}

if(!isset($language_id)) {
	// check if language was handed over
	if(isset($_POST['language_id'])) {
		$language_id = language::ISOTointernal(mysql_real_escape_string($_POST['language_id']));
		if($language_id == null) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
	}
	else {
		$language_id = language::ISOTointernal( language::getBrowserLanguage() );
	}
}

include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';

switch($action) {

	case 'get_message_delete_contract_confirm':

		echo WARNING_DELETE_CONTRACT_CONFIRM;

		break;

	case 'get_message_reset_registration_form_confirm':

		echo WARNING_REGISTRATION_RESET_FORM_CONFIRM;

		break;
		
	case 'get_message_buy_confirm':
		
		echo SUCCESS_PRODUCT_TO_SHOPPINGCART;
		
		break;
		
	case 'get_message_no_server_available':
		$product_id = mysql_escape_string($_POST['product_id']);
		$language_id = mysql_escape_string($_POST['language_id']);
		// if no language id was handed over -> use browser language
		if(!isset($_POST['language_id'])) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
		
		$product = new product($product_id, $language_id);
		
		echo sprintf(ERROR_SERVER_NOT_AVAILABLE, $product->getTitle());
		break;
}

?>
