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
	// TODO:
	public function terminate() {

	}

	public function getExpirationDate() {
		return $this->expiration_date;
	}

	public static function create($invoice_id) {
		// check if invoice is payed
		$invoice = new invoice($invoice_id);

		if($invoice->isPayed()) {

			$order = new order($invoice->getOrderID());
			$orderDetails = $order->getOrderDetails();

			// create one contract for each order position
			foreach($order->getOrderPositions() AS $order_position) {
				// if one order position has a quantity greater 1, create one contract for each of it
				for ($i = 1; $i <= $order_position['quantity']; $i++) {

					$insert_statement = 'INSERT INTO '. TBL_CONTRACT .' (customer_id, order_id, order_position_id, invoice_id, start_date, expiration_date, contract_periode) VALUES ('. $invoice->getCustomerID() .', '. $order->getOrderID() .', '. $order_position['order_position_id'] .', '. $invoice_id .', NOW() , DATE_ADD(NOW(), INTERVAL '. (int) $order_position['contract_periode'] .' DAY), '. (int) $order_position['contract_periode'] .')';
					db_query($insert_statement);

				}
			}
		}
		// invoice is still in pending status -> no contract can activate
		else {
			return sprintf(ERROR_INVOICE_NOT_PAYED, $invoice->getInvoiceNumber());
		}
	}


	// print contract overview for customer
	public static function printOverviewCustomer($customer_id, $language_id = NULL, $container_id = 'contract_overview') {
		if($language_id == NULL) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}

		// query all invoices for customer
		$sql_statement = 'SELECT q1.*, p.title AS product_name FROM (SELECT con.contract_id, con.expiration_date, con.start_date, con.contract_periode, op.product_id, no.termination_date FROM '. TBL_CONTRACT .' AS con INNER JOIN '. TBL_ORDER_POSITION .' AS op ON con.order_position_id = op.order_position_id LEFT JOIN '. TBL_NOTICE .' AS no ON con.contract_id = no.contract_id WHERE con.customer_id = '. (int) $customer_id .') AS q1 LEFT JOIN '. TBL_PRODUCT .' AS p ON q1.product_id = p.product_id  WHERE p.language_id = '. (int) $language_id .' ORDER BY q1.expiration_date ASC';
		$contract_query = db_query($sql_statement);

		$number_of_contracts = db_num_results($contract_query);

		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_CONTRACTS, $number_of_contracts);

		$return_string = $return_string .'<table>
		<tr>
		<th>'. TABLE_HEADING_CONTRACT_PRODUCT .'</th>
		<th>'. TABLE_HEADING_CONTRACT_START_DATE .'</th>
		<th>'. TABLE_HEADING_CONTRACT_EXPIRATION_DATE .'</th>
		<th>'. TABLE_HEADING_CONTRACT_CONTRACT_PERIODE .'</th>
		</tr>';

		while($data = db_fetch_array($contract_query)) {
			$return_string = $return_string .'<tr>
			<td>'. $data['product_name'] .'</td>
			<td>'. mysql_date2german($data['start_date']) .'</td>
			<td>'. mysql_date2german($data['expiration_date']) .'</td>
			<td>'. $data['contract_periode'] .' '. TABLE_HEADING_CONTRACT_EXPIRATION_DATE_UNIT .'</td>
			<td>';
			
			if($data['termination_date'] != NULL) {
				$return_string = $return_string . sprintf(LABEL_CONTRACT_TERMINATION_EXECUTION_DATE, mysql_date2german( $data['expiration_date'] ) );
			}
			else {
				$return_string = $return_string .'<a href="#!terminate_contract" id="terminate_contract" rel="'. $data['contract_id'] .'" >deleteicon</a>';
			}	
			$return_string = $return_string .'</td>
			</tr>';
		}

		$return_string = $return_string .'</table></div>';

		return $return_string;
	}


	/* private section */
	private function load() {
		$sql_statement = 'SELECT con.customer_id, con.order_id, con.invoice_id, con.start_date, con.expiration_date, con.contract_periode FROM '. TBL_CONTRACT .' AS con WHERE con.contract_id = '. (int) $this->contract_id;
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