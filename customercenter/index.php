<?php 
	
	// 	Header
	include("header.php");
	
	// 	Menu
	include("menu.php");
	
	
	if(isset($_GET['content'])){ // if a main menu element is selected
		
		// Get selected main menu element
		$content = $_GET['content'];
		
		/* Show selected content */
		switch ($content) {
		
			// Home
			case 'home':
				include("../home.php");
				break;
				// Products
			case 'products':
				include("../product.php");
				break;
				// Help
			case 'help':
				include ("../help.php");
				break;
				// Imprint
			case 'imprint':
				include ("../imprint.php");
				break;
				// Registration
			case 'customercenter':
	
				include("customercenter.php");
				break;
		}
	}
	else{
		/* If nothing ist selected show home.php */
		include("../home.php");
	}
	
// 	Footer
	include("footer.php");
?>