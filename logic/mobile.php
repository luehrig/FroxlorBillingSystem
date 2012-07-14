<?php

include_once '../configuration.inc.php';

require_once PATH_FUNCTIONS .'datetime.php';

require_once PATH_EXT_LIBRARIES .'phpmailer/class.phpmailer.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_country.php';
require_once PATH_CLASSES .'cl_currency.php';
require_once PATH_CLASSES .'cl_contract.php';

require PATH_FUNCTIONS .'database.php';

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

include_once PATH_INCLUDES .'database_tables.php';



include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';

$action = $_POST['action'];

switch($action) {

		case 'show_mobile':
			include '../menu.php';
			break;

}


?>