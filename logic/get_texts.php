<?php

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';

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

switch($action) {
	
	case 'get_message_delete_contract_confirm':
		
		echo WARNING_DELETE_CONTRACT_CONFIRM;
		
	break;
	
}

?>