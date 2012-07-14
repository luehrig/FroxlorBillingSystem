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
<link rel="stylesheet" href="css/handheld.css" media="screen and (min-device-width: 600px)" type="text/css" />
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
<div class="mainmenu">
	<ul>
		
	   <li><a href="index.php?lang=<?php echo $site_language; ?>" id="home" class="nav mm_active"><span><?php echo VIEW_MENU_HOME; ?></span></a></li>
	   <li><a href="index.php?lang=<?php echo $site_language; ?>" id="products" class="nav"><span><?php echo VIEW_MENU_PRODUCTS; ?></span></a></li>
	   
	   <!-- menu link for contact form if javascript is active (form will be opened in a popup) -->
	   <div id="contact_form_js"></div>
		<script type="text/javascript">
			document.getElementById("contact_form_js").innerHTML='<li><a href="content_js.html?lang=<?php echo $site_language; ?>" class="lightbox"><span><?php echo VIEW_MENU_CONTACT; ?></span></a></li>';
		</script>
		
		<!-- menu link for contact form if javascript is not active -->
	   <li><noscript><a href="index.php?lang=<?php echo $site_language; ?>" id="contact" class="nav"><span><?php echo VIEW_MENU_CONTACT; ?></span></a></noscript></li>
	   
	   <li><a href="index.php?lang=<?php echo $site_language; ?>" id="help" class="nav"><span><?php echo VIEW_MENU_HELP; ?></span></a></li>
	   <li><a href="index.php?lang=<?php echo $site_language; ?>" id="imprint" class="nav"><span><?php echo VIEW_MENU_IMPRINT; ?></span></a></li>
	   
	   
	   <?php 
	    /*
	     * decide if customer is logged in or not
	     * if customer is logged in add "nav" class to customer center link
	     */
	   	if (customer::isLoggedIn(session_id()) == true ) {
	   		echo '<li id="mainmenuelement"><a href="#!page=customercenter&lang='. $site_language .'" id="customercenter" class="nav"><span>'. VIEW_MENU_CUSTOMERCENTER .'</span></a></li>';
	   	}
	   	else {
	   		echo '<li id="mainmenuelement"><a href="#!page=customercenter&lang='. $site_language .'" id="customercenter"><span>'. VIEW_MENU_CUSTOMERCENTER .'</span></a></li>';
	   	}
	   ?>
	   
	</ul>
</div>
<div id="content_container" class="content_container">
</div>
</body>
</html>