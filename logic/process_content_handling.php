<?php

include_once '../configuration.inc.php';

require PATH_CLASSES .'cl_customizing.php';
require PATH_CLASSES .'cl_shoppingcart.php';

session_start();

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';
include_once PATH_LANGUAGES .'DE.inc.php';
include_once PATH_FUNCTIONS .'user_management.php';

$action = $_POST['action'];

switch($action) {
	
	// display shopping cart with all products
	case 'show_shoppingcart':
		$cart = new shoppingcart(session_id());
		echo $cart->printCart();
	break;
	
	case 'show_checkout_step1':
		
		
	break;
	
	// TODO: Append other content sites like the example above
	
}



?>