<?php 	
include_once '../configuration.inc.php';

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




		
echo '
		
<h1>Produkte</h1>
<div class="boxwrapper">

	<!-- Product No.1 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="1">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book1" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="1">'. BUTTON_MORE .'</button>
	</div>
				
				
	<!-- Product No.2 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="2">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book2" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="2">'. BUTTON_MORE .'</button>
	</div>
				
	<!-- Product No.3 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="3">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book3" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="3">'. BUTTON_MORE .'</button>
	</div>
				
</div>

';?>