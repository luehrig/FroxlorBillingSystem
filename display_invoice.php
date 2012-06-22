<?php
include_once 'configuration.inc.php';

require_once PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_EXT_LIBRARIES .'fpdf17/fpdf.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_invoicepdf.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_customer.php';

if(isset($_GET['invoice_id'])) {
	$invoice_id = $_GET['invoice_id'];
}
else {
	$invoice_id = $_POST['invoice_id'];
}

$invoice = new invoice($invoice_id);
$invoice->printInvoice();
?>