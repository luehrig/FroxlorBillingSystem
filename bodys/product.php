<?php 	
if(!isset($_GET['page'])) {
	include_once '../configuration.inc.php';
}

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
	
	foreach($product_info_map as $attribute_id => $value){
		$attribute_value_map[$existing_attributes[$attribute_id]] = $value;
	}
	
	
	// wrapper to hold the products in a line
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
			<li>'.PRODUCT_CONTRACT_PERIODE.' '.$product_data['contract_periode'].'</li>
			<li>'.PRODUCT_QUANTITY.' '.$product_data['quantity'].'</li>
			<li>'.PRODUCT_PRICE.' '.$product_data['price'].'</li>
		<button class="buttonlayout_buy" rel="'.$product_id.'">'.BUTTON_ADD_TO_CART.'</button>
		<div id="book'.$product_id.'" class="slidebox">
			<fieldset>
				<legend>
					Details
				</legend>
	
				<ul>';
	
	foreach($attribute_value_map as $attr_name => $value){
		$return_string = $return_string. '<li>'. $attr_name .' '. $value .'</li>';
	}
	
	$return_string = $return_string.
				'</ul>
			</fieldset>
		</div>
	<!-- TODO: rel tag has to content the product id! -->
	<button class="buttonlayout_more" rel="'.$product_id.'">'.PRODUCT_DETAILS_MORE.'</button>
	</div>
	
	';
	
	if($index % 3 == 0){
		$return_string = $return_string.'</div> ';
	}
	$index++;
	echo $return_string;

}
echo'</div>'

?>

