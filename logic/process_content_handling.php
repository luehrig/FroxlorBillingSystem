<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/FroxlorBillingSystem/configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_shoppingcart.php';
require_once PATH_CLASSES .'cl_content.php';

if(session_id() == '') {
	session_start();
}

require_once PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';
include_once PATH_LANGUAGES .'DE.inc.php';
include_once PATH_FUNCTIONS .'user_management.php';

if(!isset($action)) {
$action = $_POST['action'];
}

if(!isset($language_id)) {
// check if language was handed over
if(isset($_POST['language_id'])) {
	$language_id = language::ISOTointernal($_POST['language_id']);
}
else {
	$language_id = language::ISOTointernal( language::getBrowserLanguage() );
}
}

switch($action) {
	
	// show home page if no specific action was handed over
	case 'show_undefined':
		$content = new content(2,$language_id);
			
		echo $content->getTitle();
			
		echo $content->getText();
		
	break;
	
	// display shopping cart with all products
	case 'show_shoppingcart':
		$cart = new shoppingcart(session_id());
		echo $cart->printCart();
	break;
	
	case 'show_checkout_step1':
	
	break;
	
	// display imprint
	case 'show_imprint':
		include PATH_BODYS .'imprint.php';	
	break;

	// display home
	case 'show_home':
		include PATH_BODYS .'home.php';
	break;
		
	// display products
	case 'show_products':

		include PATH_BODYS .'product.php';
		
	break;
	
	case 'show_customercenter':
		
		echo '<div class="customermenu">
			<ul>
			   <li class="active"><a href="#!mydata&lang='. language::getBrowserLanguage() .'" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
			   <li><a href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
			   <li><a href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
			</ul>
		</div>';
		
		echo '<div class="customer_content_container">'.
	 		/* content depends on menu click */
		'</div>'; 

		
	break;	
	
	default:
		echo WARNING_CONTENT_NOT_FOUND;
	break;
	
	// TODO: Append other content sites like the example above
	
}



?>
