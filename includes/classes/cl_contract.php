<?php

class contract {
	
	private $contract_id;
	private $customer_id;
	private $order_id;
	private $invoice_id;
	private $start_date;
	private $expiration_date;
	
	/* constructor */
	public function __construct($contract_id) {
		$this->contract_id = $contract_id;
		
		$this->load();
	}
	
	
	/* public section */
	public static function create($invoice_id) {
		// check if invoice is payed
		$invoice = new invoice($invoice_id);
		
		if($invoice->isPayed()) {
			
			$order = new order($invoice->getOrderID());
			$orderDetails = $order->getOrderDetails();
			
			foreach($order->getOrderPositions() AS $order_position) {
				
				$insert_statement = 'INSERT INTO '. TBL_CONTRACT .' (customer_id, order_id, invoice_id, start_date, expiration_date) VALUES ('. $invoice->getCustomerID() .', '. $order->getOrderID() .', '. $invoice_id .', NOW() , DATE_ADD(NOW(), INTERVAL '. (int) $order_position['contract_periode'] .' DAY))'; 
				db_query($insert_statement);
				
			}
		}
		// invoice is still in pending status -> no contract can activate
		else {
			return sprintf(ERROR_INVOICE_NOT_PAYED, $invoice->getInvoiceNumber());
		}
	}
	
	
	/* private section */
	private function load() {
		$sql_statement = 'SELECT con.customer_id, con.order_id, con.invoice_id, con.start_date, con.expiration_date FROM '. TBL_CONTRACT .' AS con WHERE con.contract_id = '. (int) $this->contract_id;
		$query = db_query($sql_statement);
		
		$result_data = db_fetch_array($query);
		
		$this->customer_id = $result_data['customer_id'];
		$this->order_id = $result_data['order_id'];
		$this->invoice_id = $result_data['invoice_id'];
		$this->start_date = $result_data['start_date'];
		$this->expiration_date = $result_data['expiration_date'];
	}
	
}

?>