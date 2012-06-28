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

	case 'update_customer':
		$customerData = $_POST['customerData'];
		$shippingAddress = $_POST['shippingAddress'];
		$billingAddress = $_POST['billingAddress'];
		$customer_id = $_POST['customer_id'];
		$shipping_address_id = $_POST['shipping_address_id'];
		$billing_address_id = $_POST['billing_address_id'];

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

		/* $addressDiff = array_diff($shippingAddress, $billingAddress);


		if( count($addressDiff) == 0) {
			
		$customer->setDefaultBillingAddress($shipping_address_id);
		}
		else {
		// check if address for customer still exists in address pool for customer
		if($customer->hasAddress($))
				
			// update shipping address if change was requested
		if(isset($shipping_address_id) && isset($shippingAddress)) {
		$customer->updateAddress($shipping_address_id, $shippingAddress);
		}

		// update billing address if change was requested
		if(isset($billing_address_id) && isset($billingAddress)) {
		$customer->updateAddress($billing_address_id, $billingAddress);
		}
		}
		*/

		echo MSG_CHANGES_SAVED;

		break;

}

?>