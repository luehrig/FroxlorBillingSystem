<?php

include_once '../configuration.inc.php';

require_once PATH_FUNCTIONS .'datetime.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_country.php';
require_once PATH_CLASSES .'cl_currency.php';
require_once PATH_CLASSES .'cl_contract.php';

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

		$customer = new customer($_SESSION['customer_id']);
		$data = $customer->getData();
		
		echo MSG_CUSTOMER_WELCOME .', '. $data['first_name'] .' '. $data['last_name'] .'!';
		echo '<a href="#" id="logout"> '. BUTTON_LOGOUT_CUSTOMER .'</a>';
	
		break;
		
	case 'get_customer_data':
		
		$customer_id = $_SESSION['customer_id'];
		
		echo '<div class="whitebox">';
		echo '<div class="cust_data">';
		
		echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';
							
		$customer = new customer($customer_id);
		
		echo $customer->printForm();
		
		echo '</div>';
		echo '</div>';
		
	break;
	
	case 'get_edit_customer_data':
		
		$customer_id = $_SESSION['customer_id'];
		
		echo '<div class="whitebox">';		
		echo '<div class="cust_data">';
		
		echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';
		
		$customer = new customer($customer_id);
		
		echo $customer->printFormEdit();
		
		echo '</div>';
		echo '</div>';
		
	break;
		
	case 'get_customer_products':
	
		$customer_id = $_SESSION['customer_id'];
	
		echo '<div class="whitebox">';
		echo '<div class="cust_data">';
	
		echo '<h1>'.PAGE_TITLE_CUSTOMERPRODUCTS.'</h1>';
	
		echo contract::printOverviewCustomer($customer_id);
	
		echo '</div>';
		echo '</div>';
	
		break;
	
	case 'get_customer_invoices':
	
		$customer_id = $_SESSION['customer_id'];
	
		echo '<div class="whitebox">';
		echo '<div class="cust_data">';
	
		echo '<h1>'.PAGE_TITLE_CUSTOMERINVOICES.'</h1>';
	
		$customer = new customer($customer_id);
	
		// content
		echo invoice::printOverviewCustomer($customer_id);
	
		echo '</div>';
		echo '</div>';
	
		break;
		
	case 'send_email':
	
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$customer_email = $_POST['email'];
		$msg_type = $_POST['msg_type'];
		$message = $_POST['message'];
// 		$customer_id = $_POST['customer_id'];
		
		// get admin email address
		$customizing = new customizing();
		$customizing_entries = $customizing->getCustomizingComplete();
		$recipient = $customizing_entries['business_company_email'];
		
		// create subject text: message type (question/problem/feedbacke) + name
		$subject = $msg_type. ' / ' . $first_name .' '. $last_name;
		
		// send email
		mail($recipient, $subject, $message, "from:$customer_email");
		
		echo MSG_SUCCESSFULLY_SENT;
		
		break;
}	

?>