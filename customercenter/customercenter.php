<?php
// get selected customer menu element
$custcontent = $_GET['custcontent'];

include("customermenu.php");

/* Show selected content */
switch ($custcontent) {
	// Customer's Data
	case 'mydata':
		include("custdata.php");
		break;
		// Customer's Products
	case 'myproducts':
		include("custproducts.php");
		break;
		// Customer's Invoices
	case 'myinvoices':
		include("custinvoices.php");
		break;
}

?>