<?php
session_start();

include_once '../configuration.inc.php';

require '../includes/classes/cl_customizing.php';
require '../includes/classes/cl_customer.php';
require_once PATH_CLASSES .'cl_language.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';

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
	
	case 'create_customer':
		$customerData = $_POST['customerData'];
		
		customer::create($customerData);
		
	break;
	
}

?>