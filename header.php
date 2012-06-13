<?php 

require 'includes/classes/cl_customizing.php';
require 'includes/classes/cl_shoppingcart.php';

session_start();



include_once 'configuration.inc.php';

require 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require 'functions/general.php';

include_once 'includes/database_tables.php';
include_once 'includes/languages/DE.inc.php';

$cart = new shoppingcart(session_id());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Froxcloud</title>

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/colorbox.css" type="text/css">

<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script language="javascript" src="js/jquery.colorbox-min.js"></script>
<script language="javascript" src="js/general.js"></script>


</head>
<body>
<div class="header">
	<img ID="logo" src="images/fcloud.png">
	<a href="#" ID="shoppingcart"><?php echo VIEW_MENU_SHOPPING_CART; ?> (<span id="current_cart_quantity"><?php echo $cart->getNumberOfProducts(); ?></span>)</a>

</div>
