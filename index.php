<?php

// Get selected menu
if(!isset( $_GET['content'] )) {
	$content = 'home';
}
else {
	$content = $_GET['content'];
}

// 	Header
	include("header.php");
	
// 	Menu
	include("menu.php");
	
	
/* Show selected content */
	switch ($content) {
		
// Home
		case 'home': 
			include("home.php");
			break;
// Products
		case 'products':
			include("product.php");
			break;
// Help
		case 'help':
			include ("help.php");
			break;
// Imprint
		case 'imprint':
			include ("imprint.php");
			break;
	}
	
	
// 	Footer
	include("footer.php");
?>