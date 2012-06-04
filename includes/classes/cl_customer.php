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
	private $business_client;
	private $customer_number;
	private $customer_data;
	
	/* constructor */
	public function __construct($customer_id) {
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
		$this->business_client = $customer_data['business_client'];
		$this->customer_number = $customer_data['customer_number'];
	}

	/* public section */
	public function getCustomerData() {
		return $this->customer_data;
	}
	
	
	/* private section */
	private function getCustomerFromDB($customer_id) {
		$sql_statement = 'SELECT * FROM '. TBL_CUSTOMER .' WHERE customer_id = '. (int) $customer_id;
		return db_query_with_result($sql_statement);
	}
	

	
}

?>