<?php 	
if(!isset($_GET['page'])) {
	include_once '../configuration.inc.php';
}


require_once PATH_CLASSES .'cl_product.php';
require_once PATH_CLASSES .'cl_product_info.php';
require_once PATH_CLASSES .'cl_product_attribute.php';

$content = new content(1);


// new product($product_id, $language_id)
$product = new product(1, 1);

$product_title = $product->getTitle();
$contract_periode = $product->getContractPeriode();
$description = $product->getDescription();
$quantity = $product->getQuantity();
$price = $product->getPrice();

// array($ttribute_description => $value)
$attribute_value_map = array();

// return = array(atribute_id => Value);  getAttributesByProductId($product_id)
$product_info_map = productInfo::getAttributesByProductId(1);

// return = array(atribute_id => descriptione);  getAllExistingAttrByLang($language_id)
$existing_attributes = productAttribute::getAllExistingAttrByLang(1);

foreach($product_info_map as $atribute_id => $Value){
	$attribute_value_map[$existing_attributes[$atribute_id]] = $Value;
}

$numberOfProducts = 7;
$index = 0;




echo '
	<h1>'.VIEW_MENU_PRODUCTS.'</h1>
	<div class="boxwrapper">
';


while ($index <= $numberOfProducts) {
	if($index % 3 == 0){
		echo'<div class="productwrapper"> ';
	}
echo'

	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				'. $product_title.'
			</legend>
			<p>'.$description.'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="'.$index.'">'.BUTTON_ADD_TO_CART.'</button>
		<div id="book'.$index.'" class="slidebox">
			<fieldset>
				<legend>
					Details
				</legend>
				
				<ul>
  					<li>Vertragslaufzeit'.$contract_periode.'</li>
  					<li>Space '.$quantity.'</li>
  					<li>Preis '.$price.'</li>
				</ul>
			</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="'.$index.'">'.BUTTON_MORE.'</button>
	</div>

';

	if($index % 3 == 0){
		echo'</div> ';
	}
	$index++;
}
echo'</div>'

?>

