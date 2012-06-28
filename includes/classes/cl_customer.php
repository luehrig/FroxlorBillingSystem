<?php

class customer {

	private $customer_id;
	private $gender;
	private $title;
	private $first_name;
	private $last_name;
	private $company;
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

	public function getEMail() {
		return $this->email;
	}

	public function getFullName() {
		return $this->first_name .' '. $this->last_name;
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
			
		$return_string = '<div id="'. $container_id. '">';


		$return_string = $return_string .'<table class="customer_data"><tr><th>'.LABEL_LOGIN_DATA.': </th><td>'.LABEL_EMAIL.': '.$this->email. // eMail

		'<tr><th>'.LABEL_B_ADDRESS.': </th><td>';
		$return_string = $return_string.' '.$this->company.'<br>';
		if($this->gender == $customizing->getCustomizingValue('sys_gender_male') ){ // Gender
			$return_string = $return_string .SELECT_CUSTOMER_GENDER_MALE;
		}
		else{
			$return_string = $return_string .SELECT_CUSTOMER_GENDER_FEMALE;
		}
		$return_string = $return_string.' '.$this->title.' '.$this->first_name.' '.$this->last_name. // name
		'<br>'.$billing_address_data['street'].' '.$billing_address_data['street_number']. // street + number
		'<br>'.$billing_address_data['post_code'].' '.$billing_address_data['city']. // post code + city
		'<br>'. $country->getCountryName($billing_address_data['country_code']) .'</td></tr>'. // country
		'<tr><th>'.LABEL_S_ADDRESS.': </th><td>';
		if($shipping_address_data == $shipping_address_data){ // if billing address equals shipping address show checked checkbox
			$return_string = $return_string.'<input type="checkbox" name="same_adress" readonly checked>'. LABEL_SAME_ADRESS;
		}
		else{ // if not show shipping address
			$return_string = $return_string.
			$shipping_address_data['street'].' '.$shipping_address_data['street_number']. // street + number
			'<br>'.$shipping_address_data['post_code'].' '.$shipping_address_data['city']. // post code + city
			'<br>'.$country->getCountryName($shipping_address_data['country_code']).'</td></tr>'; // country
		}
		$return_string = $return_string.
		'<tr><th>'.LABEL_TELEPHONE.': </th><td>'.LABEL_TEL.': '.$this->telephone.
		'<br>'.LABEL_FAX.': '.$this->fax.'</td></tr>'.
		'</table>';


		$return_string = $return_string . '<input type="submit" name="edit_customer" id="edit_customer" rel="'. $this->customer_id .'" value="'. BUTTON_EDIT_CUSTOMER .'">';

		$return_string = $return_string .'</form></div>';

		return $return_string;
	}


	// returns customer data as HTML form (edit)
	public function printFormEdit($container_id = 'customer_editor') {
		$customizing = new customizing();
		$country = new country();

		// query shipping address
		$sql_statement = 'SELECT sa.customer_address_id, sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->shipping_address;
		$shipping_address_query = db_query($sql_statement);
		$shipping_address_data = db_fetch_array($shipping_address_query);

		// query billing address if shipping & billing address is different
		if($this->shipping_address != $this->billing_address) {
			// query billing address
			$sql_statement = 'SELECT sa.customer_address_id, sa.street, sa.street_number, sa.post_code, sa.city, sa.country_code FROM '. TBL_CUSTOMER_ADDRESS .' AS sa WHERE sa.customer_address_id = '. (int) $this->billing_address;
			$billing_address_query = db_query($sql_statement);
			$billing_address_data = db_fetch_array($billing_address_query);
		}
		// if not, set shipping address as billing address
		else {
			$billing_address_data = $shipping_address_data;
		}

		$return_string = '<div id="'. $container_id .'"><form class="edit_cust_data"><div class="edit_cust_data">';

		$return_string = $return_string .'<fieldset>'.
				//Login Data
		'<legend>'. LABEL_LOGIN_DATA .'</legend>
		<p><label for="generalemail">'. LABEL_EMAIL .'</label>
		<input type="email" id="generalemail" name="generalemail" rel="mandatory" value="'. $this->email .'"></p>
		<a href="#" id="change_pw"><'. BUTTON_CHANGE_PW. '></a>
		</fieldset>'.
			
		// General Inforamtion
		'<fieldset><legend>'. FIELDSET_GENERAL_INFORMATION .'</legend>
		<p><label for="generalgender">'. LABEL_GENDER .'</label>
		<select name="generalgender" id="generalgender" size="1" rel="mandatory">';
		if( $this->gender == $customizing->getCustomizingValue('sys_gender_male') ) {
			$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="generalgender" selected>'. SELECT_CUSTOMER_GENDER_MALE .'</option>
			<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="generalgender">'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
		}
		else {
			$return_string = $return_string .'<option id="'. $customizing->getCustomizingValue('sys_gender_male') .'" name="generalgender">'. SELECT_CUSTOMER_GENDER_MALE .'</option>
			<option id="'. $customizing->getCustomizingValue('sys_gender_female') .'" name="generalgender" selected>'. SELECT_CUSTOMER_GENDER_FEMALE .'</option>';
		}
		$return_string = $return_string .'</select></p>
		<p><label for="generaltitle">'. LABEL_TITLE .'</label>
		<input type="text" id="generaltitle" name="generaltitle" value="'. $this->title .'"></p>
		<p><label for="generalfirst_name">'. LABEL_FIRST_NAME .'</label>
		<input type="text" id="generalfirst_name" name="generalfirst_name" rel="mandatory" value="'. $this->first_name .'"></p>
		<p><label for="generallast_name">'. LABEL_LAST_NAME .'</label>
		<input type="text" id="generallast_name" name="generallast_name" rel="mandatory" value="'. $this->last_name .'"></p>
		<p><label for="generalcompany">'. LABEL_COMPANY .'</label>
		<input type="text" id="generalcompany" name="generalcompany" value="'. $this->company .'"></p>
		</fieldset>'.

		// Contact Information
		'<fieldset>
		<legend>'. FIELDSET_CUSTOMER_CONTACT_INFORMATION .'</legend>
		<p><label for="generaltelephone">'. LABEL_TELEPHONE .'</label>
		<input type="text" id="generaltelephone" name="generaltelephone" value="'. $this->telephone .'"></p>
		<p><label for="generalfax">'. LABEL_FAX .'</label>
		<input type="text" id="generalfax" name="generalfax" value="'. $this->fax .'"></p>
		</fieldset>'.

		// Address
		'<fieldset>
		<legend>'. FIELDSET_CUSTOMER_ADDRESS_INFORMATION .'</legend>
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_SHIPPING_ADDRESS_INFORMATION .'</legend>
		<div id="shippingaddress">
		<p><label for="shippingstreet">'. LABEL_STREET .'</label>
		<input type="text" id="shippingstreet" name="shippingstreet" rel="mandatory" value="'. $shipping_address_data['street'] .'"></p>
		<p><label for="shippingstreet_number">'. LABEL_STREETNUMBER .'</label>
		<input type="text" id="shippingstreet_number" name="shippingstreet_number" rel="mandatory" value="'. $shipping_address_data['street_number'] .'"></p>
		<p><label for="shippingpost_code">'. LABEL_POSTCODE .'</label>
		<input type="text" id="shippingpost_code" name="shippingpost_code" rel="mandatory" value="'. $shipping_address_data['post_code'] .'"></p>
		<p><label for="shippingcity">'. LABEL_CITY .'</label>
		<input type="text" id="shippingcity" name="shippingcity" rel="mandatory" value="'. $shipping_address_data['city'] .'"></p>
		<p><label for="shippingcountry">'. LABEL_COUNTRY .'</label>'.
		'<div class="country">'. $country->printSelectBox("shippingcountry_code","shippingcountry_code", $shipping_address_data['country_code']).
		'<input type="hidden" id="address_id_shipping" name="address_id_shipping" value="'. $shipping_address_data['customer_address_id'] .'">
		</div></p>
		</fieldset>';


		$return_string = $return_string.
		'<div id="billingaddress">
		<fieldset>
		<legend>'. FIELDSET_CUSTOMER_BILLING_ADDRESS_INFORMATION .'</legend>
		<div id="billingaddress">
		<p><label for="billingstreet">'. LABEL_STREET .'</label>
		<input type="text" id="billingstreet" name="billingstreet" rel="mandatory" value="'. $billing_address_data['street'] .'"></p>
		<p><label for="billingstreet_number">'. LABEL_STREETNUMBER .'</label>
		<input type="text" id="billingstreet_number" name="billingstreet_number" rel="mandatory" value="'. $billing_address_data['street_number'] .'"></p>
		<p><label for="billingpost_code">'. LABEL_POSTCODE .'</label>
		<input type="text" id="billingpost_code" name="billingpost_code" rel="mandatory" value="'. $billing_address_data['post_code'] .'"></p>
		<p><label for="billingcity">'. LABEL_CITY .'</label>
		<input type="text" id="billingcity" name="billingcity" rel="mandatory" value="'. $billing_address_data['city'] .'"></p>
		<p><label for="billingcountry">'. LABEL_COUNTRY .'</label>'.
		$country->printSelectBox("billingcountry_code","billingcountry_code",$billing_address_data['country_code']) .'</p>
		<input type="hidden" id="address_id_billing" name="address_id_billing" value="'. $billing_address_data['customer_address_id'] .'">
		</div>
		</fieldset>
		</fieldset>
		</div>';

		$return_string = $return_string . '<input type="submit" name="save_customer" id="save_customer" value="'. BUTTON_SAVE .'" rel="'. $this->customer_id.'">';

		$return_string = $return_string .'</div></form></div>';

		return $return_string;
	}


	// update customer
	public function update($customer_id, $customerData) {
		// build sql update string from data array
		$update_statement = 'UPDATE '. TBL_CUSTOMER .' SET ';

		foreach ($customerData as $key => $value) {
			$update_statement = $update_statement . $key .' = "'. $value .'", ';
		}

		// delete lasst comma to prevent issues with WHERE clausel
		$update_statement = substr($update_statement, 0, strlen($update_statement)-2 );

		$update_statement = $update_statement .' WHERE customer_id = '. (int) $customer_id;

		db_query($update_statement);
	}

	// update customer related address
	public function updateAddress($address_id, $addressData) {

		// build sql update string from data array
		$update_statement = 'UPDATE '. TBL_CUSTOMER_ADDRESS .' SET ';

		foreach ($addressData as $key => $value) {
			$update_statement = $update_statement . $key .' = "'. $value .'", ';
		}

		// delete lasst comma to prevent issues with WHERE clausel
		$update_statement = substr($update_statement, 0, strlen($update_statement)-2 );

		$update_statement = $update_statement .' WHERE customer_address_id = '. (int) $address_id;

		db_query($update_statement);
	}

	// delete customer from DB
	public function delete($customer_id) {
		$delete_statement = 'DELETE FROM '. TBL_CUSTOMER .' WHERE customer_id = '. (int) $customer_id;
		$delete_query_result = db_query($delete_statement);
		return $delete_query_result;

	}

	// add a new address related to customer
	public function addAddress($addressData) {
		$sql_statement = 'INSERT INTO '. TBL_CUSTOMER_ADDRESS .' (customer_id, street, street_number, post_code, city, country_code) VALUES ('. $this->customer_id .', "'. $addressData['street'] .'", "'. $addressData['street_number'] .'", "'. $addressData['post_code'] .'", "'. $addressData['city'] .'", '. (int) $addressData['country_code'] .')';
		db_query($sql_statement);

		$address_id = db_insert_id();
		return $address_id;
	}

	// delete a address related to customer
	public function deleteAddress($address_id) {
		$delete_statement = 'DELETE FROM '. TBL_CUSTOMER_ADDRESS .' WHERE customer_street_id = '. (int) $address_id;
		db_query($delete_statement);
	}

	// set new default shipping address
	public function setDefaultShippingAddress($address_id) {
		$sql_statement = 'UPDATE '. TBL_CUSTOMER .' SET shipping_address = '. (int) $address_id .' WHERE customer_id = '. (int) $this->customer_id;
		db_query($sql_statement);
	}

	// set new default billing address
	public function setDefaultBillingAddress($address_id) {
		$sql_statement = 'UPDATE '. TBL_CUSTOMER .' SET billing_address = '. (int) $address_id .' WHERE customer_id = '. (int) $this->customer_id;
		db_query($sql_statement);
	}

	// get default shipping address
	public function getDefaultShippingAddress() {
		$sql_statement = 'SELECT c.shipping_address FROM '. TBL_CUSTOMER .' AS c WHERE c.customer_id = '. (int) $this->customer_id;
		$query = db_query($sql_statement);
		$result_data = db_fetch_array($query);

		return $result_data['shipping_address'];
	}

	// get default billing address
	public function getDefaultBillingAddress() {
		$sql_statement = 'SELECT c.billing_address FROM '. TBL_CUSTOMER .' AS c WHERE c.customer_id = '. (int) $this->customer_id;
		$query = db_query($sql_statement);
		$result_data = db_fetch_array($query);

		return $result_data['billing_address'];
	}

	// get address information for specific customer address
	public function getAddressInformation($customer_address_id) {
		$sql_statement = 'SELECT ca.street, ca.street_number, ca.post_code, ca.city, co.country_name FROM '. TBL_CUSTOMER_ADDRESS .' AS ca INNER JOIN '. TBL_COUNTRY .' AS co ON ca.country_code = co.country_id WHERE ca.customer_address_id = '. (int) $customer_address_id .' AND co.language_id = '. (int) language::ISOTointernal( language::getBrowserLanguage() );
		$query = db_query($sql_statement);
		$result_data = db_fetch_array($query);

		$address_information = array();

		$address_information['street'] = $result_data['street'];
		$address_information['street_number'] = $result_data['street_number'];
		$address_information['post_code'] = $result_data['post_code'];
		$address_information['city'] = $result_data['city'];
		$address_information['country'] = $result_data['country_name'];

		return $address_information;

	}

	// return address id if address information for customer still exists
	// if it does not exists return false
	public function hasAddress($addressData) {
		$sql_statement = 'SELECT ca.customer_address_id FROM '. TBL_CUSTOMER_ADDRESS .' AS ca WHERE ca.customer_id = '. (int) $this->customer_id .' AND ca.street = "'. $addressData['street'] .'" AND ca.street_number = "'. $addressData['street_number'] .'" AND ca.post_code = "'. $addressData['post_code'] .'" AND ca.city = "'. $addressData['city'] .'" AND ca.country_code = '. (int) $addressData['country_code'];
		$query = db_query($sql_statement);
		
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			return $result_data['customer_address_id'];
		}
		else {
			return false;
		}
	}	
	
	// return true if customer is a commerical one else returns false
	public function isCommerical() {
		if($this->company != '') {
			return true;
		}
		else {
			return false;
		}
	}

	// check if customer is still logged in
	public static function isLoggedIn($session_id) {
		$sql_statement = 'SELECT ac.customer_id FROM '. TBL_ACTIVE_CUSTOMER .' AS ac WHERE ac.session_id = "'. $session_id .'" AND ac.expiration_date > NOW()';
		$query = db_query($sql_statement);

		if(db_num_results($query) == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	public static function create($customerData) {

		if($customerData != NULL) {

			/*
			 *
			* insert new customers general information into database
			* use address id 0 as default value
			*
			*/
			$sql_statement = 'INSERT INTO '. TBL_CUSTOMER .' (gender,title, first_name, last_name, company, shipping_address, billing_address, telephone, fax, email, password)
			VALUES ("'. $customerData['gender'] .'",
			"'. $customerData['title'] .'",
			"'. $customerData['first_name'] .'",
			"'. $customerData['last_name'] .'",
			"'. $customerData['company'] .'",
			0,
			0,
			"'. $customerData['telephone'] .'",
			"'. $customerData['fax'] .'",
			"'. $customerData['email'] .'",
			"'. sha1( $customerData['password'] ) .'")';

			db_query($sql_statement);
			$customer_id = db_insert_id();

			echo $customer_id;
			
			if(isset($customer_id)) {
					
				// get customizing for customer number and insert generated customer number
				$customizing = new customizing();
				$customer_prefix = $customizing->getCustomizingValue('sys_customer_prefix');
				$customer_number = $customer_prefix .'-'. $customer_id;

				$sql_statement = 'UPDATE '. TBL_CUSTOMER .' SET customer_number = "'. $customer_number .'" WHERE customer_id = '. (int) $customer_id;
				db_query($sql_statement);
					

				// create customer object to work with
				$customer = new customer($customer_id);

				/*
				 *
				* add shipping address for customer
				*
				*/

				// build array with shipping address information
				$shippingAddress['street'] = $customerData['shippingstreet'];
				$shippingAddress['street_number'] = $customerData['shippingstreetnumber'];
				$shippingAddress['post_code'] = $customerData['shippingpostcode'];
				$shippingAddress['city'] = $customerData['shippingcity'];
				$shippingAddress['country_code'] = $customerData['shippingcountry'];

				$shippingaddress_id = $customer->addAddress($shippingAddress);
				$customer->setDefaultShippingAddress($shippingaddress_id);

				// check if billing address information is set
				if(	isset($customerData['billingstreet']) &&
						isset($customerData['billingstreetnumber']) &&
						isset($customerData['billingpostcode']) &&
						isset($customerData['billingcity']) &&
						isset($customerData['billingcountry']) ) {


					// build array with billing address information
					$billingAddress['street'] = $customerData['billingstreet'];
					$billingAddress['street_number'] = $customerData['billingstreetnumber'];
					$billingAddress['post_code'] = $customerData['billingpostcode'];
					$billingAddress['city'] = $customerData['billingcity'];
					$billingAddress['country_code'] = $customerData['billingcountry'];
					
					
					$billingaddress_id = $customer->addAddress($billingAddress);
					$customer->setDefaultBillingAddress($billingaddress_id);
					
				}
				else {
					$customer->setDefaultBillingAddress($shippingaddress_id);
				}
				
				// return constructor with created data inside
				return new customer($customer_id);
			}
			else {
				return false;
			}
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
