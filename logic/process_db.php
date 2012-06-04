<?php

require '../includes/classes/cl_customizing.php';

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
		
		// first add shipping address and maybe different billing address
		$sql_statement = 'INSERT INTO '. TBL_CUSTOMER_ADDRESS .' (street, street_number, post_code, city, country_code) 
							VALUES ("'. $customerData['shippingstreet'] .'", 
									"'. $customerData['shippingstreetnumber'] .'",
									"'. $customerData['shippingpostcode'] .'", 
									"'. $customerData['shippingcity'] .'", 
									"'. $customerData['shippingcountry'] .'")';
		
		db_query($sql_statement);
		$shippingaddress_id = db_insert_id();
		
		if(	isset($customerData['billingstreet']) && 
		   	isset($customerData['billingstreetnumber']) && 
		   	isset($customerData['billingpostcode']) && 
		   	isset($customerData['billingcity']) && 
		   	isset($customerData['billingcountry']) ) {
			
			// first add shipping address and maybe different billing address
			$sql_statement = 'INSERT INTO '. TBL_CUSTOMER_ADDRESS .' (street, street_number, post_code, city, country_code)
			VALUES ("'. $customerData['billingstreet'] .'",
			"'. $customerData['billingstreetnumber'] .'",
			"'. $customerData['billingpostcode'] .'",
			"'. $customerData['billingcity'] .'",
			"'. $customerData['billingcountry'] .'")';
			
			db_query($sql_statement);
			$billingaddress_id = db_insert_id();
			
		}
		
		// if shipping and billing address is the same, set shippingaddress as billingaddress
		if(!isset($billingaddress_id)) {
			$billingaddress_id = $shippingaddress_id;
		}
		
		
		$sql_statement = 'INSERT INTO '. TBL_CUSTOMER .' (gender,title, first_name, last_name, company, shipping_address, billing_address, telephone, fax, email, password) 
						  	VALUES ("'. $customerData['gender'] .'",
						  			"'. $customerData['title'] .'",
						  			"'. $customerData['first_name'] .'",
						  			"'. $customerData['last_name'] .'",
						  			"'. $customerData['company'] .'",
									'. $shippingaddress_id .',
									'. $billingaddress_id .',
									"'. $customerData['telephone'] .'",
									"'. $customerData['fax'] .'",
									"'. $customerData['email'] .'",
									"'. sha1( $customerData['password'] ) .'")';

		db_query($sql_statement);
		$customer_id = db_insert_id();
		
 		$customer_prefix = $_SESSION['customizing']->getCustomizingValue('sys_customer_prefix');
		$customer_number = $customer_prefix .'-'. $customer_id;
		
		$sql_statement = 'UPDATE '. TBL_CUSTOMER .' SET customer_number = "'. $customer_number .'" WHERE customer_id = '. (int) $customer_id;
		db_query($sql_statement);
		
	break;
	
}

?>