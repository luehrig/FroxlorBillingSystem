<?php 	
include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_product.php';
require_once PATH_CLASSES .'cl_product_info.php';
require_once PATH_CLASSES .'cl_product_attribute.php';

$content = new content(1);

$language_id = language::ISOTointernal(language::getBrowserLanguage());

$numberOfProducts = 7;
$index = 0;

echo '
<h1>'.VIEW_MENU_PRODUCTS.'</h1>
<div class="boxwrapper">
';


/* $active_product_array:
 array(prod_id1 => array("title" => title1,
 						 "contract_periode" => contractPeriode1,
 						 "description" => description1,
 						 "quantity" => quantity1,
 						 "price" => price1),
 	   prod_id2 => array("title" => title2,
 						 "contract_periode" => contractPeriode2,
 					 	 "description" => description2,
 						 "quantity" => quantity2,
 						 "price" => price2))
*/

$active_product_array = product::getAllActiveProducts($language_id);

foreach ($active_product_array as $product_id => $product_data){
	
	// array($ttribute_description => $value)
	$attribute_value_map = array();
	
	// return = array(atribute_id => Value); 
	$product_info_map = productInfo::getAttributesByProductId($product_id);
	
	// return = array(atribute_id => descriptione);  
	$existing_attributes = productAttribute::getAllExistingAttrByLang($language_id);
	
	foreach($product_info_map as $atribute_id => $value){
		$attribute_value_map[$existing_attributes[$atribute_id]] = $value;
	}
	
	// @ Erol: Hier musst du dann die einzelnen divs für die einzelnen Produkte zusammenstellen
	
	
	
	if($index % 3 == 0){
		echo'<div class="productwrapper"> ';
	}
	$return_string = '
	
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				'. $product_data['title'].'
			</legend>
			<p>'.$product_data['description'].'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="'.$index.'">'.BUTTON_ADD_TO_CART.'</button>
		<div id="book'.$index.'" class="slidebox">
			<fieldset>
				<legend>
					Details
				</legend>
	
				<ul>
					<li>Vertragslaufzeit'.$product_data['contract_periode'].'</li>
					<li>Space '.$product_data['quantity'].'</li>
					<li>Preis '.$product_data['price'].'</li>';
	
	foreach($attribute_value_map as $attr_name => $value){
		$return_string = $return_string. '<li>'. $attr_name .' '. $value .'</li>';
	}
	
	$return_string = $return_string.
				'</ul>
			</fieldset>
		</div>
	<!-- TODO: rel tag has to content the product id! -->
	<button class="buttonlayout_more" rel="'.$index.'">'.BUTTON_MORE.'</button>
	</div>
	
	';
	
	if($index % 3 == 0){
		$return_string = $return_string.'</div> ';
	}
	$index++;
	echo $return_string;

}
echo'</div>'




// echo '
// 	<h1>'.VIEW_MENU_PRODUCTS.'</h1>
// 	<div class="boxwrapper">
// ';


// while ($index <= $numberOfProducts) {
// 	if($index % 3 == 0){
// 		echo'<div class="productwrapper"> ';
// 	}
// echo'

// 	<div class="whitebox box_3inRow">
// 		<img ID="littlelogo" src="images/logos/logo.png">
// 		<fieldset>
// 			<legend>
// 				'. $product_title.'
// 			</legend>
// 			<p>'.$description.'</p>
// 		</fieldset>
// 		<button class="buttonlayout_buy" rel="'.$index.'">'.BUTTON_ADD_TO_CART.'</button>
// 		<div id="book'.$index.'" class="slidebox">
// 			<fieldset>
// 				<legend>
// 					Details
// 				</legend>
				
// 				<ul>
//   					<li>Vertragslaufzeit'.$contract_periode.'</li>
//   					<li>Space '.$quantity.'</li>
//   					<li>Preis '.$price.'</li>
// 				</ul>
// 			</fieldset>
// 		</div>
// <!-- TODO: rel tag has to content the product id! -->			
// 		<button class="buttonlayout_more" rel="'.$index.'">'.BUTTON_MORE.'</button>
// 	</div>

// ';

// 	if($index % 3 == 0){
// 		echo'</div> ';
// 	}
// 	$index++;
// }
// echo'</div>'

?>

