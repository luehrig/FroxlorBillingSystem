<?php 
include_once 'configuration.inc.php';

session_start();

require PATH_CLASSES .'cl_customizing.php';
require PATH_CLASSES .'cl_language.php';
require PATH_CLASSES .'cl_shoppingcart.php';
require PATH_CLASSES .'cl_content.php';
require PATH_CLASSES .'cl_customer.php';
require PATH_CLASSES .'cl_product.php';
require PATH_CLASSES .'cl_product_attribute.php';
require PATH_CLASSES .'cl_product_info.php';


require 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once 'includes/database_tables.php';


require 'functions/general.php';

// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();
include_once 'includes/languages/'. strtoupper($site_language) .'.inc.php';

$cart = new shoppingcart(session_id());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>

<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Froxcloud</title>

<!-- stylesheets for lightbox, printer and desktop screen -->
<link rel="stylesheet" href="css/style.css" media="screen and (min-device-width: 600px)" type="text/css" />
<link rel="stylesheet" href="css/print.css" type="text/css" media="print">
<link rel="stylesheet" href="css/colorbox.css" type="text/css">

<!-- stylesheet for mobile devices -->
<link type="text/css" rel="stylesheet" media="only screen and (max-device-width: 599px)" href="css/handheld.css" />
<link rel="stylesheet" media="screen and (-webkit-device-pixel-ratio:0.75)" href="css/handheld.css" />
<link rel="stylesheet" href="css/handheld.css" media="handheld" type="text/css" />




<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script language="javascript" src="js/jquery.colorbox-min.js"></script>
<script language="javascript" src="js/general.js"></script>
<script language="javascript" src="js/jquery.ba-bbq.min.js"></script>

<script language="javascript" src="js/customercenter.js"></script>

<link rel="SHORTCUT ICON" href="images/logos/favicon.ico" type="image/x-icon">

</head>
<body>
<div class="header">
	<img ID="logo" src="images/fcloud.png">
	<div class="header_right">

		<a href="shoppingcart.html?lang=<?php echo $site_language; ?>" id="shoppingcart" class="nav"><?php echo VIEW_MENU_SHOPPING_CART; ?> (<span id="current_cart_quantity"><?php echo $cart->getNumberOfProducts(); ?></span>)</a>
		<br>
		<div ID="customer_header">
 		<div ID="customer_header_ajax"></div> <!-- Container for customer head when page is reloaded -->
		<?php 
			if(customer::isLoggedIn(session_id())) {
				$customer = new customer($_SESSION['customer_id']);
				$data = $customer->getData();
				
				echo '<div class="welcome_text">'. MSG_CUSTOMER_WELCOME .', '. $data['first_name'] .' '. $data['last_name'] .'!</div>';
				echo '<a href="#" id="logout"><img src="images/logout.png" id="logout" title="'. BUTTON_LOGOUT_CUSTOMER .'"></a>';
			}	
		?>
		</div>
		<div class="language_switch">
			<button class="language_button active" ID="german"> deutsch
			</button>
			<button class="language_button"  ID="english"> englisch
			</button>
		</div>

	</div>
</div>
