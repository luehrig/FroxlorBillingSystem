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
	case 'add_product_to_cart':		
		$product_id = $_POST['product_id'];
		
		$cart = new shoppingcart(session_id());
		$cart->addProduct($product_id);
		
	break;
	
	case 'get_product_count_in_cart':
		
		$cart = new shoppingcart(session_id());
		echo $cart->getNumberOfProducts();
		
	break;
	
}



?>