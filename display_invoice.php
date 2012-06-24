<?php
session_start();

include_once 'configuration.inc.php';

require_once PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

require_once PATH_FUNCTIONS .'datetime.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_currency.php';
require_once PATH_EXT_LIBRARIES .'fpdf17/fpdf.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_invoicepdf.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_content.php';

if(!isset($language_id)) {
	// check if language was handed over
	if(isset($_POST['language_id'])) {
		$language_id = language::ISOTointernal($_POST['language_id']);
		if($language_id == null) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
	}
	else {
		$language_id = language::ISOTointernal( language::getBrowserLanguage() );
	}
}

include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';


if(isset($_GET['invoice_id'])) {
	$invoice_id = $_GET['invoice_id'];
}
else {
	$invoice_id = $_POST['invoice_id'];
}

$invoice = new invoice($invoice_id);

if($invoice->isCustomerAuthorized( $_SESSION['customer_id']) ) {
	$invoice->printInvoice();
}
else {
	echo utf8_decode(WARNING_INVOICE_NOT_AUTHORIZED);
}

?>