<?php

session_start();

include_once 'configuration.inc.php';

require 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once 'includes/database_tables.php';
include_once 'includes/languages/DE.inc.php';


$action = $_POST['action'];

switch($action) {
	
	case 'create_customer':

		$gender = $_POST['gender'];
		$title = $_POST['title'];
		$company = $_POST['company'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$telephone = $_POST['telephone'];
		$fax = $_POST['fax'];
		$shipping_street = $_POST['shipping_street'];
		$shipping_streetnumber = $_POST['shipping_streetnumber'];
		$shipping_postcode = $_POST['shipping_postcode'];
		$shipping_city = $_POST['shipping_city'];
		$shipping_country = $_POST['shipping_country'];
		
	break;
	
}

?>