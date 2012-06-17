<?php

class invoice {
	
	private $invoice_data;
	
	/* constructor */
	public function __construct($invoice_id) {
		
	}
	
	
	/* public section */
	public static function create($customer_id, $issue_date, $payment_date = NULL, $order_id, $invoice_status = NULL, $currency_id, $tax_id) {
		$customizing = new customizing(language::getBrowserLanguage());
		
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
			VALUES ('. (int) $customer_id .', "'. $issue_date .'", DATE_ADD(NOW(), INTERVAL '. $payment_periode .' DAYS), '. (int) $order_id .', '. (int) $invoice_status .', '. (int) $currency_id .', '. (int) $tax_id;
		}
		
		db_query($insert_statement);
		$invoice_id = db_insert_id();
		
		if($invoice_id != false) {
			$invoice_number = $customizing->getCustomizingValue('sys_invoice_prefix') .'-'. $invoice_id;
			$update_statement = 'UPDATE '. TBL_INVOICE .' SET invoice_number = '. $invoice_number .' WHERE invoice_id = '. (int) $invoice_id;
			db_query($update_statement);
			
			return new invoice($invoice_id);
		}
	}
	
	
	/* private section */
	private function load($invoice_id) {
		//$sql_statement = 'SELECT i.issue_date, i.payment_date, i.payed_on, i.invoice_number, i.order_id, c.first_name AS customer_first_name, c.last_name AS customer_last_name, ca.street, ca.street_number, ca.post_code, ca.city, coun.country_name, '
	}
}

?>