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
	
				include("customermenu.php");
				
				include("custdata.php");
				break;
		}
	}
	elseif (isset($_GET['custcontent'])){ // if a customer menu element is selected
		// get selected customer menu element
		$custcontent = $_GET['custcontent'];
		
		include("customermenu.php");
		
		/* Show selected content */
		switch ($custcontent) {
			// Customer's Data
			case 'mydata':
				include("custdata.php");
				break;
				// Customer's Products
			case 'myproducts':
				include("custproducts.php");
				break;
				// Customer's Invoices
			case 'myinvoices':
				include("custinvoices.php");
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