<?php

include_once '../configuration.inc.php';

require PATH_CLASSES .'cl_customizing.php';
require PATH_CLASSES .'cl_language.php';
require PATH_CLASSES .'cl_shoppingcart.php';
require PATH_CLASSES .'cl_content.php';

session_start();

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';
include_once PATH_LANGUAGES .'DE.inc.php';
include_once PATH_FUNCTIONS .'user_management.php';

$action = $_POST['action'];

// check if language was handed over
if(isset($_POST['language_id'])) {
	$language_id = language::ISOTointernal($_POST['language_id']);
}
else {
	$language_id = language::ISOTointernal( language::getBrowserLanguage() );
}

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
		echo $cart->printCart();
	break;
	
	case 'show_checkout_step1':
		
		
	break;
	
	case 'show_imprint':
	
		include PATH_BODYS .'imprint.php';	

	break;

	// content of home
	case 'show_home':
		
		$content = new content(2,$language_id);
		
	echo '	
	<div class"content_container">
		<h1>'.$content->getTitle() .'</h1>
		<div class="boxwrapper">
			<div class=" whitebox box_1inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>Herzlich Willkommen</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>

			<div class="whitebox box_2inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>Info</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
			<div class="whitebox box_2inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>Zusatz</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
	
			<div class=" whitebox box_4inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>News</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
			<div class="whitebox box_4inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>News</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
			<div class="whitebox box_4inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>News</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
			<div class="whitebox box_4inRow">
				<img ID="minilogo" src="images/logos/logo.png">
				<h3>News</h3>
				<div class="textbox">'. $content->getText() .'</div>
			</div>
		</div>
	<div>';
		
	break;
		
	//content of products
	case 'show_products':
		$content = new content(1);
		
		echo '
		
		<h1>'.$content->getTitle() .'</h1>
		<div class="boxwrapper">
		
		<!-- Product No.1 -->
		<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<br>
		Produktname
		<div class="textbox">'. $content->getText() .'</div>
		<button class="buttonlayout_buy" rel="1">'. BUTTON_ADD_TO_CART .'</button>
					<div id="book1" class="slidebox">
						<div class="textbox">'. $content->getText() .'</div>
					</div>
		<!-- TODO: rel tag has to content the product id! -->			
					<button class="buttonlayout_more" rel="1">'. BUTTON_MORE .'</button>
				</div>
				
				
				<!-- Product No.2 -->
				<div class="whitebox box_3inRow">
					<img ID="littlelogo" src="images/logos/logo.png">
					<br>
					Produktname
					<div class="textbox">'. $content->getText() .'</div>
					<button class="buttonlayout_buy" rel="2">'. BUTTON_ADD_TO_CART .'</button>
					<div id="book2" class="slidebox">
						<div class="textbox">'. $content->getText() .'</div>
					</div>
		<!-- TODO: rel tag has to content the product id! -->			
					<button class="buttonlayout_more" rel="2">'. BUTTON_MORE .'</button>
				</div>
				
				<!-- Product No.3 -->
				<div class="whitebox box_3inRow">
					<img ID="littlelogo" src="images/logos/logo.png">
					<br>
					Produktname
					<div class="textbox">'. $content->getText() .'</div>
					<button class="buttonlayout_buy" rel="3">'. BUTTON_ADD_TO_CART .'</button>
					<div id="book3" class="slidebox">
						<div class="textbox">'. $content->getText() .'</div>
						
					</div>
		<!-- TODO: rel tag has to content the product id! -->			
					<button class="buttonlayout_more" rel="3">'. BUTTON_MORE .'</button>
				</div>
				
				
			</div>';
		
	break;
	
	case 'show_customercenter':
		
		echo '<div class="customermenu">
	<ul>
	   <li class="active"><a href="#!mydata&lang='. language::getBrowserLanguage() .'" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
	   <li><a href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
	   <li><a href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
	</ul>
</div>';
		
	break;	
	
	default:
		echo WARNING_CONTENT_NOT_FOUND;
	break;
	
	// TODO: Append other content sites like the example above
	
}



?>
