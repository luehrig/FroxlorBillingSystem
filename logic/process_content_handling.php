<?php

require '../includes/classes/cl_customizing.php';
require '../includes/classes/cl_shoppingcart.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require '../functions/general.php';

include_once '../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';
include_once '../functions/user_management.php';

$action = $_POST['action'];

switch($action) {
	
	// display shopping cart with all products
	case 'show_shoppingcart':
		echo "Warenkorb bitte sehr!";
		
		$cart = new shoppingcart(session_id());
		
		echo $cart->printCart();
	break;
	
	// TODO: Append other content sites like the example above
	
}



?>