<?php
session_start();

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_language.php';

require_once PATH_FUNCTIONS .'database.php';
require_once PATH_FUNCTIONS .'security.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once PATH_INCLUDES .'database_tables.php';

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


$action = $_POST['action'];

switch($action) {

	case 'create_customer':
		$customerData = db_security_escape_string_array($_POST['customerData']);

		customer::create($customerData);

		break;

	case 'update_customer':
		$customerData = db_security_escape_string_array($_POST['customerData']);
		$shippingAddress = db_security_escape_string_array($_POST['shippingAddress']);
		$billingAddress = db_security_escape_string_array($_POST['billingAddress']);
		$customer_id = mysql_real_escape_string($_POST['customer_id']);
		$shipping_address_id = mysql_real_escape_string($_POST['shipping_address_id']);
		$billing_address_id = mysql_real_escape_string($_POST['billing_address_id']);

		$customer = new customer($customer_id);
		$customer->update($customer_id, $customerData);

		// check if entered address information still exists as address data sets
		$identified_shipping_address_id = $customer->hasAddress($shippingAddress);
		$identified_billing_address_id = $customer->hasAddress($billingAddress);

		// if shipping address does not exist -> add address and set as default shipping address
		if($identified_shipping_address_id == false) {
			$new_shipping_address_id = $customer->addAddress($shippingAddress);
			$customer->setDefaultShippingAddress($new_shipping_address_id);
		}
		else {
			$customer->setDefaultShippingAddress($identified_shipping_address_id);
		}

		// if billing address does not exist -> add address and set as default billing address
		if($identified_billing_address_id == false) {
			$new_billing_address_id = $customer->addAddress($billingAddress);
			$customer->setDefaultBillingAddress($new_billing_address_id);
		}
		else {
			$customer->setDefaultBillingAddress($identified_billing_address_id);
		}

		echo MSG_CHANGES_SAVED;

		break;

}

?>