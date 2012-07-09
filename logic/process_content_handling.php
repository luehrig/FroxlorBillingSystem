<?php
if(!isset($_GET['page'])) {
	include_once '../configuration.inc.php';
}

require_once PATH_EXT_LIBRARIES .'fpdf17/fpdf.php';
require_once PATH_EXT_LIBRARIES .'phpmailer/class.phpmailer.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_shoppingcart.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_currency.php';
require_once PATH_CLASSES .'cl_country.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_invoicepdf.php';
require_once PATH_CLASSES .'cl_server.php';
require_once PATH_CLASSES .'cl_content.php';

require_once PATH_FUNCTIONS .'datetime.php';

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

// if(customer::isLoggedIn( session_id() )) {
// // 	$customer_id = $_SESSION['customer_id'];
// }

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
		
		echo '<h1>'. VIEW_MENU_SHOPPING_CART. '</h1>';
		echo '<div class="boxwrapper">';
		echo '<div class=" whitebox box_1inRow">';
		echo '<fieldset>';
		echo '<legend> Warenkorb </legend>';
		
		echo $cart->printCart(NULL, true);
					
		echo '</fieldset>';
		echo '</div>';
		echo '</div>';

		break;

	case 'show_checkout_step1':


		echo 'Melden Sie sich an oder erstellen Sie ein neues Kundenkonto um zu bestellen.';
		
		echo '<a href="login.html" id="cartlogin" class="nonav">Einloggen</a>';


		break;

	case 'show_checkout_step2':
		$content = new content(3,$language_id);
			
		echo '<h1>'. $content->getTitle(). '</h1>';
		
		echo '<div class="boxwrapper">';
		echo '<div class="whitebox box_1inRow">';
		echo '<fieldset>';
		
		echo $content->getText();
		
		echo '</fieldset>';
		echo '</div>';
		

		echo '<div class="whitebox box_1inRow">';	
		echo '<fieldset>';
		echo '<div id="accept_terms"><input type="checkbox" id="check_terms" name="check_terms" value="0">'. LABEL_ACCEPT_TERMS .'</div>';
		echo '</fieldset>';
		echo '</div>';
		echo '<div class="message_box"></div>';

		echo '<a href="checkout_step3.html&lang='. language::internalToISO($language_id) .'" id="checkout_step3" class="nonav">'. BUTTON_CHECKOUT_NEXT .'</a>';
		

		echo '</div>';
		break;

		// message that customer has to accept terms
	case 'show_alert_accept_terms':

		echo WARNING_CHECKOUT_PLEASE_ACCEPT_TERMS;

		break;

		// show address information
	case 'show_checkout_step3':
		echo '<h1>Rechnungs- und Lieferadresse</h1>';
		echo '<div class="boxwrapper">';
		echo '<div class="whitebox box_1inRow">';
		

		$customer = new customer($_SESSION['customer_id']);
		echo $customer->printAddressForm();
		
		echo '<a href="checkout_step4.html&lang='. language::internalToISO($language_id) .'" id="checkout_step4" class="nonav">'. BUTTON_CHECKOUT_NEXT .'</a>';
		
		echo '</div>';
		
		

		break;

		// show address information
	case 'show_checkout_step4':
		// get address arrays form address selction screen
		$shippingAddress = $_POST['shippingAddress'];
		$billingAddress = $_POST['billingAddress'];
		
		// get customer object
		$customer = new customer($_SESSION['customer_id']);
		
		// check if shipping and billing address is still in database
		// if this is not the case -> add address information
		$identified_shipping_address = $customer->hasAddress($shippingAddress);
		$identified_billing_address = $customer->hasAddress($billingAddress);
		
		if($identified_shipping_address == false) {
			$identified_shipping_address = $customer->addAddress($shippingAddress);
		}
		
		if($identified_billing_address == false) {
			$identified_billing_address = $customer->addAddress($billingAddress);
		}
		
		// write address information (address ids into hidden fields)
		echo '<input type="hidden" id="shipping_address_id" name="shipping_address_id" value="'. $identified_shipping_address .'">';
		echo '<input type="hidden" id="billing_address_id" name="billing_address_id" value="'. $identified_billing_address .'">'; 
		
		echo '<h1>'.HEADING_ORDER_OVERVIEW.'</h1>';
		echo '<div class="boxwrapper">';
		echo '<div class="whitebox box_1inRow">';
		echo '<fieldset>';

		$cart = new shoppingcart(session_id());
		echo $cart->printCart();
		echo '</fieldset>';
		echo '</div>';

		echo '<a href="order_received.html&lang='. language::internalToISO($language_id) .'" id="save_order" class="nonav">'. BUTTON_CHECKOUT_SEND_ORDER .'</a>';

		break;

		// show info page to say "your order has been send successfully"
	case 'show_order_received':
		
		// init neccessary objects for processing
		$customizing = new customizing();
		
		$cart = new shoppingcart(session_id());
		$cart_products = $cart->getProducts();
			
		$customer = new customer($_SESSION['customer_id']);
		
		
		// get address information for order
		$shipping_address_id = $_POST['shipping_address_id'];
		$billing_address_id = $_POST['billing_address_id'];
		
		// if something went wrong with address id handling use default address information for customer
		if(!isset($shipping_address_id)) {
			$shipping_address_id = $customer->getDefaultShippingAddress();
		}
		
		if(!isset($billing_address_id)) {
			$billing_address_id = $customer->getDefaultBillingAddress();
		}
		
		
			
		$order = order::create($_SESSION['customer_id'], $shipping_address_id, $billing_address_id, NULL, NULL, $cart_products);

		$invoice = invoice::create($_SESSION['customer_id'], NULL, NULL, $order->getOrderID(), NULL, $customizing->getCustomizingValue('business_payment_default_currency') , $customizing->getCustomizingValue('business_payment_default_tax'));
			
			
		$invoice->sendInvoice( );
			
			
		echo 'Ihre Bestellung wurde erfolgreich an unser Team übermittelt!';

		// delete cart with ordered products
		shoppingcart::deleteCart(session_id());

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

		//contact form (is only used when javascript is not active)
	case 'show_contact':
		include PATH_BODYS .'contact.php';
		break;		

		//content of help
	case 'show_help':
		include PATH_BODYS .'help.php';
		break;

	case 'show_customercenter':

		echo '<div class="customermenu">
		<ul>
		<li><a class="cm cm_active" href="#!mydata&lang='. language::getBrowserLanguage() .'" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
		<li><a class="cm" href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
		<li><a class="cm" href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
		</ul>
		</div>';
		echo '<div class="internalwrapper">';
		echo '<div class="whitebox internal">';
		echo '<fieldset>';
		
		// message area
		echo '<div class="messagearea">'; 
		// error message area
		echo '<div id="error_msg_area">'.'</div>';
		echo '</div>';
		
		echo '<div class="customer_content_container">';
	 		/* content depends on menu click */
		echo MSG_CUSTOMER_WELCOME;	
		echo '</div>';
		echo '</div>';
		echo '</div>';

		break;

		// TODO: is this correct?
		// 	case 'show_help':
		// 		include BASE_DIR .'help.php';
		// 	break;

	case 'show_registration':

		include PATH_BODYS .'registration.php';

		break;

	case 'show_specific_page':
		$destination = $_POST['destination'];
		
		header($destination);
		
		break;
		
	default:
		echo WARNING_CONTENT_NOT_FOUND;
		break;

		// TODO: Append other content sites like the example above

}



?>
