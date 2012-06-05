<?php

require '../includes/classes/cl_customizing.php';
require '../includes/classes/cl_customer.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';


$action = $_POST['action'];

switch($action) {
	
	case 'create_customer':
		$customerData = $_POST['customerData'];
		
		customer::create($customerData);
		
	break;
	
}

?>