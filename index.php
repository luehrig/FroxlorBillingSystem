<?php
$content = $_GET['content'];

// 	Header
	include("header.php");
	
// 	Menu
	include("menu.php");
	
// 	Content
	switch ($content) {
		case 'home': 
			echo "Heimat!";
			include("home.php");
		break;
		case 'products':
			echo "Produkte!"; 
			include("product.php");
		break;
		case 'help':
			echo "Hilfe!";
			break;
		case 'imprint':
			echo "Impressium!";
			break;
		
		
	}
	
	
// 	Footer
	include("footer.php");
?>
