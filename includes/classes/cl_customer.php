<?php

class customer {
	
	private $gender;
	private $title;
	private $first_name;
	private $last_name;
	private $shipping_address;
	private $billing_address;
	private $telephone;
	private $fax;
	private $email;
	private $customer_number;
	private $customer_data;
	
	/* constructor */
	public function __construct($customer_id = NULL) {
		// constructor with customer data or empty constructor?
		if($customer_id != NULL) {
			$customer_data = $this->getCustomerFromDB($customer_id);
			
			$this->customer_data = $customer_data;
			
			$this->gender = $customer_data['gender'];
			$this->title = $customer_data['title'];
			$this->first_name = $customer_data['first_name'];
			$this->last_name = $customer_data['last_name'];
			$this->shipping_address = $customer_data['shipping_address'];
			$this->billing_address = $customer_data['billing_address'];
			$this->telephone = $customer_data['telephone'];
			$this->fax = $customer_data['fax'];
			$this->email = $customer_data['email'];
			$this->customer_number = $customer_data['customer_number'];
		}
	}
	
	/* public section */
	public function getCustomerData() {
		return $this->customer_data;
	}
	
	public function create($customerData) {
		
		if($customerData != NULL) {
		
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
			
			// return constructor with created data inside
			return new customer($customer_id);
			
		}
		else {
			return false;
		}
	}
	
	/* private section */
	private function getCustomerFromDB($customer_id) {
		$sql_statement = 'SELECT * FROM '. TBL_CUSTOMER .' WHERE customer_id = '. (int) $customer_id;
		$info_query = db_query($sql_statement);
		return db_fetch_array($info_query);
	}
	

	
}

?>