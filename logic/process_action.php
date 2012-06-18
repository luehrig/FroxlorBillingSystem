<?php

require '../includes/classes/cl_customizing.php';
require '../includes/classes/cl_language.php';
require '../includes/classes/cl_content.php';
require '../includes/classes/cl_customer.php';
require '../includes/classes/cl_country.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require '../functions/general.php';

include_once '../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';

$customizing = new customizing( get_default_language() );

$action = $_POST['action'];

switch($action) {

	case 'get_customer_data':
		
		$customer_id = $_POST['customer_id'];
		
		echo '<div class="whitebox">';
		echo '<div class="cust_data">';
		
		echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';
							
		$customer = new customer($customer_id);
		
		echo $customer->printForm();
		
		echo '</div>';
		echo '</div>';
		
	break;
	
	case 'get_edit_customer_data':
		
		$customer_id = $_POST['customer_id'];
		
		echo '<div class="whitebox">';		
		echo '<div class="cust_data">';
		
		echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';
		
		$customer = new customer($customer_id);
		
		echo $customer->printFormEdit();
		
		echo '</div>';
		echo '</div>';
		
	break;

}	

?>