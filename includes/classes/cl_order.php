<?php

class order {
	
	private $order_id;
	private $customer_id;
	private $order_date;
	private $order_status;
	private $order_status_id;
	private $order_positions = array();
	
	/* constructor */
	public function __construct($order_id, $language_id = NULL) {
		// read default language from customizing if no language id was given
		if($language_id == null) {
			$language_id = customizing::get_default_language();
		}
		
		$this->load($order_id, $language_id);
	}
	
	
	/* public section */
	// create order with shoppingcart object
	public static function createWithShoppingcart($cart) {
		
	}
	
	public static function create($customer_id, $order_date = NULL, $order_status = NULL, $order_positions) {
		$customizing = new customizing();
		
		// if no order status was passed use default order status from customizing
		if($order_status == NULL) {
			$order_status = $customizing->getCustomizingValue('business_standard_order_status');
		}
		
		// insert order master data
		// use current date 
		if($order_date == NULL) {
			$insert_statement = 'INSERT INTO '. TBL_ORDER .' (customer_id, order_date, order_status) 
									VALUES ('. (int) $customer_id .', NOW(), '. (int) $order_status .')';
		}
		// use passed order date
		else {
			$insert_statement = 'INSERT INTO '. TBL_ORDER .' (customer_id, order_date, order_status)
									VALUES ('. (int) $customer_id .', '. $order_date .', '. (int) $order_status .')';
		}
		
		db_query($insert_statement);
		$order_id = db_insert_id();
		
		if($order_id != false) {
			
			for($i=0; $i < count($order_positions); $i++) {
				// reset variables that were used before
				$order_position_id = null;
				
				$insert_statement = 'INSERT INTO '. TBL_ORDER_POSITION .' (order_id, product_id, quantity) 
										VALUES ('. (int) $order_id .', '. (int) $order_positions[$i]['product_id'] .', '. (int) $order_positions[$i]['quantity'] .')';
				
				db_query($insert_statement);
				$order_position_id = db_insert_id();
				
				$insert_statement = 'INSERT INTO '. TBL_ORDER_POSITION_DETAIL .' (order_position_id, server_id, froxlor_customer_id) 
										VALUES ('. (int) $order_position_id .', '. (int) $order_position_id[$i]['server_id'] .', '. (int) $order_positions[$i]['froxlor_customer_id'] .')';
				
			}
			
		}
		
		
	}
	
	
	/* private section */
	private function load($order_id, $language_id) {
		// read all data to order
		if( $this->loadMasterData($order_id, $language_id) == true) {
			$this->loadOrderPositions($order_id, $language_id);
		}
		// order was unable to read from DB return null object to caller
		else {
			return null;
		}
		
	
	}
	
	// load master data
	private function loadMasterData($order_id, $language_id) {
		$sql_statement = 'SELECT o.order_id, o.customer_id, o.order_date, o.order_status AS order_status_id, os.description AS status FROM '. TBL_ORDER .' AS o INNER JOIN '. TBL_ORDER_STATUS .' AS os ON o.order_status = os.order_status_id WHERE o.order_id = '. (int) $order_id .' AND os.language_id = '. (int) $language_id;
		$query = db_query($sql_statement);
		
		// order found in DB
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			
			$this->order_id = $result_data['order_id'];
			$this->customer_id = $result_data['customer_id'];
			$this->order_date = $result_data['order_date'];
			$this->order_status = $result_data['status'];
			$this->order_status_id = $result_data['order_status_id'];
			
			return true;
		}
		else {
			return false;
		}
	}
	
	// load all order positions to order
	private function loadOrderPositions($order_id, $language_id) {
		
		$sql_statement = 'SELECT op.quantity, p.title, p.contract_periode, p.description, p.price, p.price * op.quantity AS amount FROM '. TBL_ORDER_POSITION .' AS op INNER JOIN '. TBL_PRODUCT .' AS p ON op.product_id = p.product_id WHERE op.order_id = '. (int) $order_id .' AND p.language_id = '. (int) $language_id;
		$query = db_query($sql_statement);
		
		// order positions found
		if(db_num_results($query) > 0) {
			while($row = db_fetch_array($query)) {
				array_push($this->order_positions, $row);
			}
		}
		
	}
	
}



?>