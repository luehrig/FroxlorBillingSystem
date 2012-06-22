<?php

class invoice {

	private $order;
	private $customer;
	private $invoice_id;
	private $invoice_data;
	private $order_data;
	private $order_positions;
	private $customer_data;
	private $shipping_address;
	private $billing_address;
	

	/* constructor */
	public function __construct($invoice_id) {
		$this->invoice_id = $invoice_id;

		$this->load();

	}


	/* public section */
	// getter for class attributes
	public function getInvoiceData() {
		return $this->invoice_data;
	}

	public function getOrderData() {
		return $this->order_data;
	}
	
	public function getOrderPositions() {
		return $this->order_positions;
	}
	
	public function getCustomerData() {
		return $this->customer_data;
	}
	
	public function getShippingAddress() {
		return $this->shipping_address;
	}
	
	public function getBillingAddress() {
		return $this->billing_address;
	}
	
	public function getInvoiceID() {
		return $this->invoice_id;
	}
	
	public function getOrderID() {
		return $this->invoice_data['order_id'];
	}

	public function getIssueDate() {
		return $this->invoice_data['issue_date'];
	}
	
	public function getInvoiceNumber() {
		return $this->invoice_data['invoice_number'];
	}
	
	public function getGrossAmount() {
		return $this->invoice_data['invoice_sum_gross'];
	}
	
	public function getCurrency() {
		return $this->invoice_data['currency_id'];
	}
	
	public function getStatus($language_id = NULL) {
		if($language_id == NULL) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
		
		$sql_statement = 'SELECT ist.description AS status FROM '. TBL_INVOICE .' AS i INNER JOIN '. TBL_INVOICE_STATUS .' AS ist ON i.invoice_status = ist.invoice_status_id WHERE i.invoice_id = '. (int) $this->invoice_id .' AND ist.language_id = '. (int) $language_id;
		$query = db_query($sql_statement);
		
		$result = db_fetch_array($query);
	
		return $result['status'];
	}
	
	// create new invoice in DB
	public static function create($customer_id, $issue_date = NULL, $payment_date = NULL, $order_id, $invoice_status = NULL, $currency_id, $tax_id) {
		$customizing = new customizing(language::getBrowserLanguage());

		// if no issue date was set use current day
		if($issue_date == NULL) {
			$issue_date = date('Y-m-d');
		}
		
		// if no payment date is set get standard value from customizing
		if($payment_date == NULL) {
			$payment_periode = $customizing->getCustomizingValue('business_standard_payment_periode');
		}

		// if no invoice status is set get standard value from customizing
		if($invoice_status == NULL) {
			$invoice_status = $customizing->getCustomizingValue('business_standard_invoice_status');
		}
		
		// insert statement if payment periode was given
		if(!isset($payment_periode)) {
			$insert_statement = 'INSERT INTO '. TBL_INVOICE .' (customer_id, issue_date, payment_date, order_id, invoice_status, currency_id, tax_id)
			VALUES ('. (int) $customer_id .', "'. $issue_date .'", "'. $payment_date .'", '. (int) $order_id .', '. (int) $invoice_status .', '. (int) $currency_id .', '. (int) $tax_id .')';
		}
		// payment date has to be calculated with payment periode up to now from customizing
		else {
			$insert_statement = 'INSERT INTO '. TBL_INVOICE .' (customer_id, issue_date, payment_date, order_id, invoice_status, currency_id, tax_id)
			VALUES ('. (int) $customer_id .', "'. $issue_date .'", DATE_ADD(NOW(), INTERVAL '. $payment_periode .' DAY), '. (int) $order_id .', '. (int) $invoice_status .', '. (int) $currency_id .', '. (int) $tax_id .')';
		}

		db_query($insert_statement);
		$invoice_id = db_insert_id();

		if($invoice_id != false) {
			$invoice_number = $customizing->getCustomizingValue('sys_invoice_prefix') .'-'. $invoice_id;
			$update_statement = 'UPDATE '. TBL_INVOICE .' SET invoice_number = "'. $invoice_number .'" WHERE invoice_id = '. (int) $invoice_id;
			db_query($update_statement);
				
			return new invoice($invoice_id);
		}
	}

	// print invoice as pdf document
	public function printInvoice() {
		//create pdf
		$invoicepdf = new invoicepdf($this->invoice_id);

		// output pdf
		$invoicepdf->Output();
	}

	// check if customer is authorized to view invoice
	public function isCustomerAuthorized($customer_id) {
		if( $this->customer->getCustomerID() == $customer_id) {
			return true;
		}
		else {
			return false;
		}
	} 
	
	// print invoice overview for customer
	public static function printOverviewCustomer($customer_id, $container_id = 'invoice_overview') {
		// query all invoices for customer
		$sql_statement = 'SELECT i.invoice_id FROM '. TBL_INVOICE .' AS i WHERE i.customer_id = '. (int) $customer_id .' ORDER BY i.issue_date ASC';
		$invoice_query = db_query($sql_statement);
	
		$number_of_invoices = db_num_results($invoice_query);
	
		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_INVOICES, $number_of_invoices);
	
		$return_string = $return_string .'<table>
		<tr>
		<th>'. TABLE_HEADING_INVOICE_INVOICE_NUMBER .'</th>
		<th>'. TABLE_HEADING_INVOICE_ISSUE_DATE .'</th>
		<th>'. TABLE_HEADING_INVOICE_AMOUNT .'</th>
		<th>'. TABLE_HEADING_INVOICE_INVOICE_STATUS .'</th>
		</tr>';
	
		while($data = db_fetch_array($invoice_query)) {
			$invoice = new invoice($data['invoice_id']);
			$currency = new currency($invoice->getCurrency());
			
			$return_string = $return_string .'<tr>
			<td>'. $invoice->getInvoiceNumber() .'</td>
			<td>'. mysql_date2german($invoice->getIssueDate()) .'</td>
			<td>'. sprintf("%9.2f", $invoice->getGrossAmount()) . $currency->getCurrencySign() .'</td>
			<td>'. $invoice->getStatus() .'</td>
			<td><a href="display_invoice.php?invoice_id='. $invoice->getInvoiceID() .'" id="display_invoice" target="_blank">displayicon</a></td>
			</tr>';
		}
	
		$return_string = $return_string .'</table></div>';
	
		return $return_string;
	}

	
	/* private section */
	private function load() {
		$sql_statement = 'SELECT i.issue_date, i.payment_date, i.payed_on, i.invoice_number, i.order_id, i.currency_id, t.tax_rate FROM '. TBL_INVOICE .' AS i LEFT JOIN '. TBL_TAX .' AS t ON i.tax_id = t.tax_id WHERE i.invoice_id = '. $this->invoice_id;
		$query = db_query($sql_statement);

		if($query != NULL) {
			$result_data = db_fetch_array($query);
				
			$this->invoice_data['issue_date'] = $result_data['issue_date'];
			$this->invoice_data['payment_date'] = $result_data['payment_date'];
			$this->invoice_data['payed_on'] = $result_data['payed_on'];
			$this->invoice_data['invoice_number'] = $result_data['invoice_number'];
			$this->invoice_data['order_id'] = $result_data['order_id'];
			$this->invoice_data['currency_id'] = $result_data['currency_id'];
			$this->invoice_data['tax_rate'] = $result_data['tax_rate'];
			
			// load additional information from via related classes
			$this->loadOrder($this->invoice_data['order_id']);
			$this->loadCustomer($this->order_data['customer_id']);
			
			$this->loadFinancials();
			
		}
		else {
			return NULL;
		}
	}

	// load order that is related to invoice
	private function loadOrder($order_id) {
		// get data from order object
		$this->order = new order($order_id);

		$this->order_data      	= $this->order->getOrderDetails();
		$this->order_positions 		= $this->order->getOrderPositions();
	}

	// load customer data for order
	private function loadCustomer($customer_id) {
		$this->customer = new customer($customer_id);
		$this->customer_data = $this->customer->getData();
		$this->shipping_address = $this->customer->getAddressInformation( $this->order_data['shipping_address_id'] );
		$this->billing_address = $this->customer->getAddressInformation( $this->order_data['billing_address_id'] );
	}
	
	// load financial information
	private function loadFinancials() {
		$this->loadNetSum();
		$this->loadTaxSum();
		$this->loadGrossSum();		
	}
	
	private function loadNetSum() {
		$sql_statement = 'SELECT SUM(op.price * op.quantity) AS net FROM '. TBL_ORDER_POSITION .' AS op WHERE op.order_id = '. (int) $this->order_data['order_id'];
		$query = db_query($sql_statement);
		$result = db_fetch_array($query);
		
		$this->invoice_data['invoice_sum_net'] = $result['net'];
	}
	
	
	private function loadTaxSum() {
		$sql_statement = 'SELECT SUM(op.price * op.quantity) * '. ($this->invoice_data['tax_rate'] / 100) .' AS gross FROM '. TBL_ORDER_POSITION .' AS op WHERE op.order_id = '. (int) $this->order_data['order_id'];
		$query = db_query($sql_statement);
		$result = db_fetch_array($query);
		
		$this->invoice_data['invoice_sum_tax'] = $result['gross'];
	}
	
	private function loadGrossSum() {
		$this->invoice_data['invoice_sum_gross'] = $this->invoice_data['invoice_sum_net'] + $this->invoice_data['invoice_sum_tax'];
	}
}

?>