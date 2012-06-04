<?php

require '../../includes/classes/cl_customizing.php';

session_start();

include_once '../../configuration.inc.php';

require '../../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';


$action = $_POST['action'];

switch($action) {
	
	case 'save_customizing_entry':
		
		$key = $_POST['key'];
		$value = $_POST['value'];
		$language = $_POST['language'];
		
		// check if entry is language dependent
		$sql_statement = 'SELECT language_id FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "'. $key .'"';
		$query_result = db_query($sql_statement);
		
		$result_set = db_fetch_array($query_result);
				
		// customizing entry is language dependent
		if($result_set['language_id'] != '') {
			$update_statement = 'UPDATE '. TBL_CUSTOMIZING .' AS cust SET cust.value = "'. $value .'" WHERE cust.key = "'. $key .'" AND cust.language_id = '. (int) $language;
		}
		// entry is language independent
		else {
			$update_statement = 'UPDATE '. TBL_CUSTOMIZING .' AS cust SET cust.value = "'. $value .'" WHERE cust.key = "'. $key .'"';
		}
		
		db_query($update_statement);
		
	break;
	
}

?>
