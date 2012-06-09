<?php

// 	Header
	include("header.php");
	
// 	Menu
	include("menu.php");

	
	if(!isset($_GET['content']))
	{
		// if nothing is selected show home.php
		include("home.php");
	}
	else{
		// Get selected menu
		$content = $_GET['content'];

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
	}

// 	Footer
	include("footer.php");
?>
