<?php

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_product.php';
require_once PATH_CLASSES .'cl_shoppingcart.php';
require_once PATH_CLASSES .'cl_contract.php';
require_once PATH_CLASSES .'cl_notice.php';
require_once PATH_CLASSES .'cl_server.php';

require_once PATH_FUNCTIONS .'datetime.php';
require_once PATH_FUNCTIONS .'security.php';

if(session_id() == '') {
	session_start();
}

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';
include_once PATH_FUNCTIONS .'user_management.php';

if(!isset($language_id)) {
	// check if language was handed over
	if(isset($_POST['language_id'])) {
		$language_id = language::ISOTointernal(mysql_real_escape_string($_POST['language_id']));
		if($language_id == null) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
	}
	else {
		$language_id = language::ISOTointernal( language::getBrowserLanguage() );
	}
}

include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';

$action = $_POST['action'];

switch($action) {

	/*
	 *
	* shopping cart
	*
	*/
	// check if server for product is available
	case 'check_server_for_product':
		$product_id = mysql_real_escape_string($_POST['product_id']);
		
		$recommended_server = server::getAppropriateServer($product_id, 1);
		
		if($recommended_server != null) {
			echo 'true';
		}
		else {
			echo 'false';
		}
		
		break;
	
	// display shopping cart with all products
	case 'add_product_to_cart':
		$product_id = mysql_real_escape_string($_POST['product_id']);

		$cart = new shoppingcart(session_id());
		$cart->addProduct($product_id);

		break;

	case 'get_product_count_in_cart':

		$cart = new shoppingcart(session_id());
		echo $cart->getNumberOfProducts();

		break;

	case 'remove_product_from_cart':

		$product_id = mysql_real_escape_string($_POST['product_id']);

		$cart = new shoppingcart(session_id());
		$cart->removeProduct($product_id);

		break;

	case 'decrease_product_in_cart':

		$product_id = mysql_real_escape_string($_POST['product_id']);
		$quantity = mysql_real_escape_string($_POST['quantity']);

		$cart = new shoppingcart(session_id());
		$cart->removeProduct($product_id,$quantity);

		break;

	case 'increase_product_in_cart':

		$product_id = mysql_real_escape_string($_POST['product_id']);
		$quantity = mysql_real_escape_string($_POST['quantity']);

		$cart = new shoppingcart(session_id());
		$cart->addProduct($product_id,$quantity);

		break;

	case 'get_product_amount_in_cart':

		$product_id = mysql_real_escape_string($_POST['product_id']);

		$cart = new shoppingcart(session_id());
		echo $cart->getProductAmount($product_id);

		break;

		/*
		 *
	 * customer center
	 *
	 */

	case 'terminate_contract':

		$contract_id = mysql_real_escape_string($_POST['contract_id']);

		$notice = notice::create($contract_id);

		if($notice != NULL) {
			echo sprintf(SUCCESS_CONTRACT_TERMINATION, mysql_date2german( $notice->getExecutionDate() ) );
		}
			
		break;

}



?>