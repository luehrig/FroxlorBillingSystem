<?php

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_country.php';

if(session_id() == '') {
	session_start();
}

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

include_once PATH_INCLUDES .'database_tables.php';

$customizing = new customizing( language::getBrowserLanguage() );

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

	case 'show_customer_header':

		echo MSG_CUSTOMER_WELCOME;
		echo '<a href="#" id="logout"> '. BUTTON_LOGOUT_CUSTOMER .'</a>';
	
		break;
	
	case 'show_customer_header':
	
		echo '';
		break;
		
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
		
		case 'get_customer_products':
		
			$customer_id = $_POST['customer_id'];
		
			echo '<div class="whitebox">';
			echo '<div class="cust_data">';
		
			echo '<h1>'.PAGE_TITLE_CUSTOMERPRODUCTS.'</h1>';
		
			$customer = new customer($customer_id);
		
			// content
		
			echo '</div>';
			echo '</div>';
		
			break;
		
		case 'get_customer_invoices':
		
			$customer_id = $_POST['customer_id'];
		
			echo '<div class="whitebox">';
			echo '<div class="cust_data">';
		
			echo '<h1>'.PAGE_TITLE_CUSTOMERINVOICES.'</h1>';
		
			$customer = new customer($customer_id);
		
			// content
		
			echo '</div>';
			echo '</div>';
		
			break;
}	

?>