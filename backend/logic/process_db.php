<?php

require '../../includes/classes/cl_customizing.php';

session_start();

include_once '../../configuration.inc.php';

require '../../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require '../../functions/general.php';

include_once '../../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';

$customizing = new customizing( get_default_language() );

$action = $_POST['action'];

switch($action) {
	
	// save modified customizing entry
	case 'save_customizing_entry':
		
		$key = $_POST['key'];
		$value = $_POST['value'];
		$language = $_POST['language'];
		
		$customizing->saveEntry($key, $value, $language);
		
	break;
	
}

?>
