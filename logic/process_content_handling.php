<?php

include_once '../configuration.inc.php';

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
//include_once PATH_LANGUAGES .'DE.inc.php';
include_once PATH_FUNCTIONS .'user_management.php';

if(!isset($action)) {
$action = $_POST['action'];
}

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

switch($action) {
	
	// show home page if no specific action was handed over
	case 'show_undefined':
		$content = new content(2,$language_id);
			
		echo $content->getTitle();
			
		echo $content->getText();
		
	break;
	
	// display shopping cart with all products
	case 'show_shoppingcart':
		
		include PATH_BODYS .'shoppingcart.php';

	break;
	
	case 'show_checkout_step1':
		
		echo 'Melden Sie sich an oder erstellen Sie ein neues Kundenkonto um zu bestellen.';
		
	break;
	
	case 'show_checkout_step2':
		
		echo 'Sie können sofort weitermachen, weil Sie bereits als Kunde angemeldet sind.';
	
		echo '<a href="#!page=checkout_step3&lang='. language::internalToISO($language_id) .'" id="checkout_step3" class="nav">'. BUTTON_CHECKOUT_NEXT .'</a>';
		
	break;
	
	case 'show_checkout_step3':
	
		// TODO: change content ID to AGB entry
		$content = new content(3,$language_id);
			
		echo $content->getTitle();
			
		echo $content->getText();
	
		echo '<div id="accept_terms"><input type="checkbox" id="check_terms" name="check_terms" value="0">'. LABEL_ACCEPT_TERMS .'</div>';
		echo '<a href="#!page=checkout_step4&lang='. language::internalToISO($language_id) .'" id="checkout_step4" class="nonav">'. BUTTON_CHECKOUT_NEXT .'</a>';
		
		break;
	
	case 'show_imprint':
	
		include PATH_BODYS .'imprint.php';	

	break;

	// content of home
	case 'show_home':
		include PATH_BODYS .'home.php';
	break;
		
	//content of products
	case 'show_products':
		include PATH_BODYS .'product.php';
	break;
	
	case 'show_customercenter':
		
		echo '<div class="customermenu">
			<ul>
			   <li class="active"><a href="#!mydata&lang='. language::getBrowserLanguage() .'" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
			   <li><a href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
			   <li><a href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
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
