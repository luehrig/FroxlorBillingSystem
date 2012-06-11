<?php

class customer {
	
	private $customer_id;
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
	public function __construct($customer_id) {
		$customer_data = $this->getCustomerFromDB($customer_id);
		
		$this->customer_data = $customer_data;
		
		$this->customer_id = $customer_id;
		$this->gender = $customer_data['gender'];
		$this->title = $customer_data['title'];
		$this->first_name = $customer_data['first_name'];
		$this->last_name = $customer_data['last_name'];
		$this->shipping_address = $customer_data['shipping_address'];
		$this->billing_address = $customer_data['billing_address'];
		$this->telephone = $customer_data['telephone'];
		$this->fax = $customer_data['fax'];
		$this->email = $customer_data['email'];
		$this->company = $customer_data['company'];
		$this->customer_number = $customer_data['customer_number'];
	}
	
	/* public section */
	public function getData() {
		return $this->customer_data;
	}
	
	public function getCustomerID() {
		return $this->customer_id;
	}
	
	// returns customer data as HTML form (read-only)
	public function printForm($container_id = 'customer_editor') {
		$customizing = new customizing();
		$country = new country();
		
		// query shipping address
		$sql_statement = 'SELECT sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->shipping_address;
		$shipping_address_query = db_query($sql_statement);
		$shipping_address_data = db_fetch_array($shipping_address_query);
		
		// query billing address if shipping & billing address is different
		if($this->shipping_address != $this->billing_address) {
			// query billing address
			$sql_statement = 'SELECT sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->billing_address;
			$billing_address_query = db_query($sql_statement);
			$billing_address_data = db_fetch_array($billing_address_query);
		}
		// if not, set shipping address as billing address
		else {
			$billing_address_data = $shipping_address_data;
		}
			
		$return_string = '<div id="'. $container_id .'"><form>';
		
		$return_string = $return_string .'<fieldset>
    										<legend>'. FIELDSET_CUSTOMER_GENERAL_INFORMATION .'</legend>
    											<label for="gender">'. LABEL_GENDER .'</label>
    												<select name="gender" id="gender" size="1" rel="mandatory" readonly>';
      													if( $this->gender == $customizing->getCustomizingValue('sys_gender_male') ) {
      														$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="gender" selected>'. SELECT_CUSTOMER_GENDER_MALE .'</option>
      														<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="gender">'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
      													}
      													else {
      														$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="gender">'. SELECT_CUSTOMER_GENDER_MALE .'</option>
      														<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="gender" selected>'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
      													}
    												$return_string = $return_string .'</select>
											    	<label for="title">'. LABEL_TITLE .'</label>
											    	<input type="text" id="title" name="title" value="'. $this->title .'" readonly>
											    	<label for="company">'. LABEL_COMPANY .'</label>
											    	<input type="text" id="company" name="company" value="'. $this->company .'" readonly>
											    	<label for="first_name">'. LABEL_FIRST_NAME .'</label>
											    	<input type="text" id="first_name" name="first_name" rel="mandatory" value="'. $this->first_name .'" readonly>
											    	<label for="last_name">'. LABEL_LAST_NAME .'</label>
											    	<input type="text" id="last_name" name="last_name" rel="mandatory" value="'. $this->last_name .'" readonly>
											    </fieldset>
											    <fieldset>
											    <legend>'. FIELDSET_CUSTOMER_CONTACT_INFORMATION .'</legend>
											    	<label for="email">'. LABEL_EMAIL .'</label>
											    	<input type="text" id="email" name="email" rel="mandatory" value="'. $this->email .'" readonly>
											    	<label for="telephone">'. LABEL_TELEPHONE .'</label>
											    	<input type="text" id="telephone" name="telephone" value="'. $this->telephone .'" readonly>
											    	<label for="fax">'. LABEL_FAX .'</label>
											    	<input type="text" id="fax" name="fax" value="'. $this->fax .'" readonly>
											    </fieldset>
											    <fieldset>
											    <legend>'. FIELDSET_CUSTOMER_ADDRESS_INFORMATION .'</legend>
											    	<fieldset>
											    	<legend>'. FIELDSET_CUSTOMER_SHIPPING_ADDRESS_INFORMATION .'</legend>
											    	<div id="shippingaddress">
											    		<label for="shippingstreet">'. LABEL_STREET .'</label>
											    		<input type="text" id="shippingstreet" name="shippingstreet" rel="mandatory" value="'. $shipping_address_data['street'] .'" readonly>
											    		<label for="shippingstreetnumber">'. LABEL_STREETNUMBER .'</label>
											    		<input type="text" id="shippingstreetnumber" name="shippingstreetnumber" rel="mandatory" value="'. $shipping_address_data['street_number'] .'" readonly>
											    		<label for="shippingpostcode">'. LABEL_POSTCODE .'</label>
											    		<input type="text" id="shippingpostcode" name="shippingpostcode" rel="mandatory" value="'. $shipping_address_data['post_code'] .'" readonly>
											    		<label for="shippingcity">'. LABEL_CITY .'</label>
											    		<input type="text" id="shippingcity" name="shippingcity" rel="mandatory" value="'. $shipping_address_data['city'] .'" readonly>
											    		<label for="shippingcountry">'. LABEL_COUNTRY .'</label>'.
											    		$country->printSelectBox("shippingcountry","shippingcountry", $shipping_address_data['country_code']) .'
											    	</div>
											    	</fieldset>
											    	<fieldset>
											    	<legend>'. FIELDSET_CUSTOMER_BILLING_ADDRESS_INFORMATION .'</legend>
											    	<div id="billingaddress">
											    		<label for="billingstreet">'. LABEL_STREET .'</label>
											    		<input type="text" id="billingstreet" name="billingstreet" rel="mandatory" value="'. $billing_address_data['street'] .'" readonly>
											    		<label for="billingstreetnumber">'. LABEL_STREETNUMBER .'</label>
											    		<input type="text" id="billingstreetnumber" name="billingstreetnumber" rel="mandatory" value="'. $billing_address_data['street_number'] .'" readonly>
											    		<label for="billingpostcode">'. LABEL_POSTCODE .'</label>
											    		<input type="text" id="billingpostcode" name="billingpostcode" rel="mandatory" value="'. $billing_address_data['post_code'] .'" readonly>
											    		<label for="billingcity">'. LABEL_CITY .'</label>
											    		<input type="text" id="billingcity" name="billingcity" rel="mandatory" value="'. $billing_address_data['city'] .'" readonly>
											    		<label for="billingcountry">'. LABEL_COUNTRY .'</label>'.
											    		$country->printSelectBox("billingcountry","billingcountry",$billing_address_data['country_code']) .'
											    	</div>
											    	</fieldset>
											    </fieldset>';
		
												$return_string = $return_string . '<input type="submit" name="edit_customer" id="edit_customer" rel="'. $this->customer_id .'" value="'. BUTTON_EDIT_CUSTOMER .'">';
		
		$return_string = $return_string .'</form></div>';
		
		return $return_string;
	}
	
	
	// returns customer data as HTML form (edit)
	public function printFormEdit($container_id = 'customer_editor') {
		$customizing = new customizing();
		$country = new country();
	
		// query shipping address
		$sql_statement = 'SELECT sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->shipping_address;
		$shipping_address_query = db_query($sql_statement);
		$shipping_address_data = db_fetch_array($shipping_address_query);
	
		// query billing address if shipping & billing address is different
		if($this->shipping_address != $this->billing_address) {
			// query billing address
			$sql_statement = 'SELECT sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->billing_address;
			$billing_address_query = db_query($sql_statement);
			$billing_address_data = db_fetch_array($billing_address_query);
		}
		// if not, set shipping address as billing address
		else {
			$billing_address_data = $shipping_address_data;
		}
			
		$return_string = '<div id="'. $container_id .'"><form>';
	
		$return_string = $return_string .'<fieldset>
		<legend>'. FIELDSET_CUSTOMER_GENERAL_INFORMATION .'</legend>
		<label for="gender">'. LABEL_GENDER .'</label>
		<select name="gender" id="gender" size="1" rel="mandatory">';
		if( $this->gender == $customizing->getCustomizingValue('sys_gender_male') ) {
			$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="gender" selected>'. SELECT_CUSTOMER_GENDER_MALE .'</option>
			<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="gender">'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
		}
		else {
			$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="gender">'. SELECT_CUSTOMER_GENDER_MALE .'</option>
			<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="gender" selected>'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
		}
		$return_string = $return_string .'</select>
		<label for="title">'. LABEL_TITLE .'</label>
		<input type="text" id="title" name="title" value="'. $this->title .'">
		<label for="company">'. LABEL_COMPANY .'</label>
		<input type="text" id="company" name="company" value="'. $this->company .'">
		<label for="first_name">'. LABEL_FIRST_NAME .'</label>
		<input type="text" id="first_name" name="first_name" rel="mandatory" value="'. $this->first_name .'">
		<label for="last_name">'. LABEL_LAST_NAME .'</label>
		<input type="text" id="last_name" name="last_name" rel="mandatory" value="'. $this->last_name .'">
		</fieldset>
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_CONTACT_INFORMATION .'</legend>
		<label for="email">'. LABEL_EMAIL .'</label>
		<input type="text" id="email" name="email" rel="mandatory" value="'. $this->email .'">
		<label for="telephone">'. LABEL_TELEPHONE .'</label>
		<input type="text" id="telephone" name="telephone" value="'. $this->telephone .'">
		<label for="fax">'. LABEL_FAX .'</label>
		<input type="text" id="fax" name="fax" value="'. $this->fax .'">
		</fieldset>
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_ADDRESS_INFORMATION .'</legend>
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_SHIPPING_ADDRESS_INFORMATION .'</legend>
		<div id="shippingaddress">
		<label for="shippingstreet">'. LABEL_STREET .'</label>
		<input type="text" id="shippingstreet" name="shippingstreet" rel="mandatory" value="'. $shipping_address_data['street'] .'">
		<label for="shippingstreetnumber">'. LABEL_STREETNUMBER .'</label>
		<input type="text" id="shippingstreetnumber" name="shippingstreetnumber" rel="mandatory" value="'. $shipping_address_data['street_number'] .'">
		<label for="shippingpostcode">'. LABEL_POSTCODE .'</label>
		<input type="text" id="shippingpostcode" name="shippingpostcode" rel="mandatory" value="'. $shipping_address_data['post_code'] .'">
		<label for="shippingcity">'. LABEL_CITY .'</label>
		<input type="text" id="shippingcity" name="shippingcity" rel="mandatory" value="'. $shipping_address_data['city'] .'">
		<label for="shippingcountry">'. LABEL_COUNTRY .'</label>'.
		$country->printSelectBox("shippingcountry","shippingcountry", $shipping_address_data['country_code']) .'
		</div>
		</fieldset>
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_BILLING_ADDRESS_INFORMATION .'</legend>
		<div id="billingaddress">
		<label for="billingstreet">'. LABEL_STREET .'</label>
		<input type="text" id="billingstreet" name="billingstreet" rel="mandatory" value="'. $billing_address_data['street'] .'">
		<label for="billingstreetnumber">'. LABEL_STREETNUMBER .'</label>
		<input type="text" id="billingstreetnumber" name="billingstreetnumber" rel="mandatory" value="'. $billing_address_data['street_number'] .'">
		<label for="billingpostcode">'. LABEL_POSTCODE .'</label>
		<input type="text" id="billingpostcode" name="billingpostcode" rel="mandatory" value="'. $billing_address_data['post_code'] .'">
		<label for="billingcity">'. LABEL_CITY .'</label>
		<input type="text" id="billingcity" name="billingcity" rel="mandatory" value="'. $billing_address_data['city'] .'">
		<label for="billingcountry">'. LABEL_COUNTRY .'</label>'.
		$country->printSelectBox("billingcountry","billingcountry",$billing_address_data['country_code']) .'
		</div>
		</fieldset>
		</fieldset>';
	
		$return_string = $return_string . '<input type="submit" name="save_customer" id="save_customer" value="'. BUTTON_SAVE .'">';
	
		$return_string = $return_string .'</form></div>';
	
		return $return_string;
	}
	
	
	// update customer
	public function update($customer_id, $customerData) {
		// build sql update string from data array
		$update_statement = 'UPDATE '. TBL_CUSTOMER .' AS cust SET ';
		
		foreach ($customerData as $key => $value) {
			$update_statement = $update_statement .'cust.'. $key .' = '. $value .' ';
		}
		
		$update_statement = $update_statement .'WHERE cust.customer_id = '. (int) $customer_id;
		
		db_query($update_statement);
	}
	
	// delete customer from DB
	public function delete($customer_id) {
		$delete_statement = 'DELETE * FROM '. TBL_CUSTOMER .' AS cust WHERE cust.customer_id = '. (int) $customer_id;
		$delete_query_result = db_query($delete_statement);
		return $delete_query_result;
		
	}
	
	public static function create($customerData) {
		
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
	
	public static function printOverview($container_id = 'customer_overview') {
		$sql_statement = 'SELECT c.customer_id, c.customer_number, c.first_name, c.last_name FROM '. TBL_CUSTOMER .' AS c ORDER BY c.last_name ASC, c.first_name ASC';
		$customer_query = db_query($sql_statement);
		
		$number_of_customers = db_num_results($customer_query);
		
		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_CUSTOMERS, $number_of_customers);
		
		$return_string = $return_string .'<table>
					<tr>
					 <th>'. TABLE_HEADING_CUSTOMER_CUSTOMER_NUMBER .'</th>
					 <th>'. TABLE_HEADING_CUSTOMER_FIRST_NAME .'</th>
					 <th>'. TABLE_HEADING_CUSTOMER_LAST_NAME .'</th>
					</tr>';
		
		while($data = db_fetch_array($customer_query)) {
			$return_string = $return_string .'<tr>
					<td>'. $data['customer_number'] .'</td>
					<td>'. $data['first_name'] .'</td>
					<td>'. $data['last_name'] .'</td>
					<td><a href="#" id="edit_customer" rel="'. $data['customer_id'] .'">Icon</a></td>
				  </tr>';
		}

		$return_string = $return_string .'</table></div>';

		return $return_string;
	}
	
	/* private section */
	private function getCustomerFromDB($customer_id) {
		$sql_statement = 'SELECT * FROM '. TBL_CUSTOMER .' WHERE customer_id = '. (int) $customer_id;
		$info_query = db_query($sql_statement);
		return db_fetch_array($info_query);
	}
	

	
}

?>