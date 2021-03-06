<?php

class product {
	
	private $product_id;
	private $language_id;
	private $title;
	private $contract_periode;
	private $description;
	private $quantity;
	private $price;
	private $active;
	private $product_data;
	
	/* constructor */
	public function __construct($product_id = NULL, $language_id = NULL) {
		if($product_id != NULL and $language_id != NULL){ // TODO PRIMARY KEYS
			$product_data = $this->getData($product_id, $language_id);
			$this->product_data = $product_data;
			$this->product_id = $product_data['product_id'];
			$this->language_id = $product_data['language_id'];
			$this->title = $product_data['title'];
			$this->contract_periode = $product_data['contract_periode'];
			$this->description = $product_data['description'];
			$this->quantity = $product_data['quantity'];
			$this->price = $product_data['price'];
			$this->active = $product_data['active'];		
		}		
	}
	/* public section */
		
	// return price (optional in other language)
	public function getPrice($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.price FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['price'];
			}
			else {
				return $this->price;
			}
		}
		else {
			return false;
		}
	}
	
	// returns product title
	public function getTitle() {
		return $this->title;
	}
	
	// creates new product or tranlates product
	public static function create($product_data) {
		if($product_data != NULL){
			
			// create new product
			if($product_data['product_id'] == null){
				$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT .' (language_id, title, contract_periode, description, quantity, price)
				VALUES (
				"'. $product_data['language_id'] .'",
				"'. $product_data['title'] .'",
				"'. $product_data['contract_periode'] .'",
				"'. $product_data['description'] .'",
				"'. $product_data['quantity'] .'",
				"'. $product_data['price'] .'")';
				return db_query($sql_insert_statement);
			}
			// translate product with same product_id
			else{
				$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT .' (product_id, language_id, title, contract_periode, description, quantity, price, active)
				VALUES (
				"'. $product_data['product_id'] .'",
				"'. $product_data['language_id'] .'",
				"'. $product_data['title'] .'",
				"'. $product_data['contract_periode'] .'",
				"'. $product_data['description'] .'",
				"'. $product_data['quantity'] .'",
				"'. $product_data['price'] .'",
				"'. $product_data['active'].'")';
				return db_query($sql_insert_statement);
			}
		}
	}
	
	//deletes product from db
	public function delete() {
		$sql_delete_statement = 'DELETE FROM '. TBL_PRODUCT .' WHERE product_id = "'. (int) $this->product_id.'" AND language_id = "'. $this->language_id. '"';
		return db_query($sql_delete_statement);
	}
	
	// changes a product in db
	public function update($product_data) {
		// makes sure that the changed data are given
		if($product_data != NULL){
			$sql_update_statement = 'UPDATE '. TBL_PRODUCT .' SET
				language_id="'. $product_data['language_id'] .'", 
				title="'. $product_data['title'] .'", 
				contract_periode="'. $product_data['contract_periode'] .'", 
				description="'. $product_data['description'].'", 
				quantity="'. $product_data['quantity'] .'", 
				price="'. $product_data['price'] .'", 
				active="'. $product_data['active'] .'" 
				WHERE product_id="'. $this->product_id .'" AND language_id = "'. $this->language_id. '"' ;
			
			return db_query($sql_update_statement);
		}
	}
	
	// returns overview of all products which are saved in the same language as the browser language as HTML
	public static function printOverview($shown_language_id, $id_language_map, $container_id = 'product_overview'){
		
		$sql_statement = 'SELECT p.product_id, p.language_id, p.title, p.contract_periode, p.description, p.quantity, p.price, p.active FROM '. TBL_PRODUCT .' AS p WHERE p.language_id="'. $shown_language_id .'" ORDER BY p.product_id ASC';
		$product_query = db_query($sql_statement);
		$number_of_products = db_num_results($product_query);
		
		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_PRODUCTS, $number_of_products) ;
				
		$create_button = '<a href="#" id="create_new_product" class="button_style">'.BUTTON_CREATE_NEW_PRODUCT.'</a></td>';
		
		$return_string = $return_string;
		
		// build table header
		$table_header = '<table border = "0">
		<tr>
		<th>'. TABLE_HEADING_PRODUCT_LANGUAGE .'</th>
		<th>'. TABLE_HEADING_PRODUCT_TITLE .'</th>
		<th>'. TABLE_HEADING_PRODUCT_CONTRACT_PERIODE.'</th>
		<th>'. TABLE_HEADING_PRODUCT_DESCRIPTION.'</th>
		<th>'. TABLE_HEADING_PRODUCT_QUANTITY .'</th>
		<th>'. TABLE_HEADING_PRODUCT_PRICE .'</th>
		<th></th>
		</tr>';
		
		// build table content
		$table_content = '';
		// loop through tablerows and print every product
		while($data = db_fetch_array($product_query)) {
			
			$primary_keys = $data['product_id'].','.$data['language_id']; // CSV product_id, language_id
			
			$active = $data['active'];
			$change_state;
			// print image to deactivate product
			if($active==1){
				$change_state = '<img src="'. PATH_IMAGES_REL .'deactivate.png" title="'. LINK_DEACTIVATE_PRODUCT .'">';
			}
			// print image to activate product
			elseif($active==0){
				$change_state = '<img src="'. PATH_IMAGES_REL .'activate.png" title="'. LINK_ACTIVATE_PRODUCT .'">';
			}
			$table_content = $table_content .'<tr>
			<td>'. $id_language_map[$data['language_id']] .'</td>
			<td>'. $data['title'] .'</td>
			<td>'. $data['contract_periode'] .'</td>
			<td>'. $data['description'] .'</td>
			<td>'. $data['quantity'] .'</td>
			<td>'. $data['price'] .'</td>
			<td><a href="#" id="edit_product" rel="'. $primary_keys .'"><img src="'. PATH_IMAGES_REL .'edit.png" title="'. LINK_EDIT_PRODUCT .'"></a><br>
			<a href="#" id="translate_product" rel="'. $primary_keys .'"><img src="'. PATH_IMAGES_REL .'translate.png" title="'. LINK_TRANSLATE_PRODUCT . '"></a><br>
			<a href="#" id="change_product_state" rel="'. $primary_keys .'">'. $change_state . '</a><br>
			<a href="#" id="delete_product" rel="'. $primary_keys .'"><img src="'. PATH_IMAGES_REL .'delete.png" title="'. LINK_DELETE . '"></a></td>
			</tr>';
		}
		// put table parts together
		$return_string = $return_string . $table_header . $table_content. '</table><br>';
		$return_string = $return_string.  $create_button.'<br>';
		return $return_string;
	}
	
	// returns form to edit product and add attributes to product as HTML
	public function printFormEdit($attributesForLang, $product_info, $language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">'.
		$this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_edit_product" id="submit_edit_product" value="'. BUTTON_SAVE_CHANGES .'">';
		$return_string = $return_string . '</form></fieldset>';
		
		$return_string = $return_string . $this->getAttributeEditForm($attributesForLang, $product_info);
		$return_string = $return_string . '<input type="submit" name="submit_edit_attributes" id="submit_edit_attributes" value="'. BUTTON_SAVE_CHANGES .'">';
		$return_string = $return_string . '<input type="submit" name="give_prod_new_attr" id="give_prod_new_attr" value="'. BUTTON_NEW_ATTR_FOR_PROD .'">'; 
		$return_string = $return_string . '</form></fieldset>';
		$return_string = $return_string. '</div>';
		return $return_string;
		
	}
	
	// returns form to translate the product as HTML
	public function printFormTranslate($language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">'.
		$this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_translate_product" id="submit_translate_product" value="'. BUTTON_SAVE_CHANGES .'">';
		
		$return_string = $return_string . '</form>';
		$return_string = $return_string. '</div>';
		return $return_string;
	}
	
	// calls function which creates the same product with an other language in db
	public function saveTranslatedProduct($product_data){
		return $this->create($product_data);
	}
	
	// calls function which checks if product already exists in db
	public function entryExists($product_data){
		return $this->productExists($product_data);
	}
	
	// returns form to create a new product as HTML
	public static function printCreateProductForm($language_select_box, $container_id = 'new_product_editor'){
		$sql_statement = 'SELECT p.product_id, p.language_id, p.title, p.contract_periode, p.description, p.quantity, p.price FROM '. TBL_PRODUCT .' AS p ORDER BY p.title ASC';
		$product_query = db_query($sql_statement);
		$number_of_products = db_num_results($product_query);
		$new_product_id = $number_of_products + 1;
		
		$return_string = '<div id="'.$container_id.'">'.
		'<form method="post" class="form_backend">'.'<fieldset>'.
		'<legend>'.
		'<label for="product_id_notation">'. LABEL_PRODUCT_ID .' </label>'.
		'<label for="product_id">'. $new_product_id.' </label>'.
		'</legend>'.
		'<label for="language_id">'. LABEL_PRODUCT_LANGUAGE. '</label> '.
		$language_select_box . // dropdown box which shows all supported languages
		'<label for="title">'. LABEL_PRODUCT_TITLE .'</label>'.
		'<input type="text" id="title" name="title"><br>'.
		'<label for="contract_periode">'. LABEL_PRODUCT_CONTRACT_PEROIDE .'</label>'.
		'<input type="text" id="contract_periode" name="contract_periode">'.
		'<label for="contract_periode_unit">'. LABEL_PRODUCT_CONTRACT_PEROIDE_UNIT .'</label><br>'.
		'<label for="describtion">'. LABEL_PRODUCT_DESCRIPTION .'</label><br>'.
		'<textarea cols="20" rows="4" id="description" name="description" ></textarea><br>'.
		'<label for="quantity">'. LABEL_PRODUCT_QUANTITY .'</label>'.
		'<input type="text" id="quantity" name="quantity"><br>'.
		'<label for="price">'. LABEL_PRODUCT_PRICE .'</label>'.
		'<input type="text" id="price" name="price"><br>';
		
		$return_string = $return_string . '</fieldset>';
		$return_string = $return_string . '<input type="submit" name="save_product" id="save_product" value="'. BUTTON_SAVE .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
		
	}
	
	// checks if product exists
	public static function productExists($product_data, $compareable_product_id){		
		$sql_statement = 'SELECT * FROM '. TBL_PRODUCT .' WHERE
		language_id = "'. $product_data['language_id'] .'" AND
		title = "'. $product_data['title'] .'" AND
		contract_periode = "'. $product_data['contract_periode'] .'" AND
		description = "'. $product_data['description'] .'" AND
		quantity = "'. $product_data['quantity'] .'" AND
		price = "'. $product_data['price'].'"';
		$info_query = db_query($sql_statement);
		$db_content = db_fetch_array($info_query);
		// same product
		if($db_content['product_id'] == $compareable_product_id){
			return false;
		}
		// no other matches found
		if($db_content == ""){
			return false;
		}
		// found an other product with identical attributes
		else return true;
	}
	
	// checks if translation of product already exists
	public static function translatedProductExists($product_data){
		$sql_statement = 'SELECT * FROM '. TBL_PRODUCT .' WHERE
		product_id = "'. $product_data['product_id'].'" AND 
		language_id = "'. $product_data['language_id'] .'" AND
		title = "'. $product_data['title'] .'" AND
		contract_periode = "'. $product_data['contract_periode'] .'" AND
		description = "'. $product_data['description'] .'" AND
		quantity = "'. $product_data['quantity'] .'" AND
		price = "'. $product_data['price'].'"';
		$info_query = db_query($sql_statement);
		$db_content = db_fetch_array($info_query);
		if($db_content != ''){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	// changes product state 
	public function changeProductState($product_data){		
		$sql_update_statement = 'UPDATE '. TBL_PRODUCT .' SET active="' . $product_data['active'] . '" WHERE
		product_id="' . $product_data['product_id'] . '"';  
		return db_query($sql_update_statement);
	}
	
	// returns product data by language and id from db
	public function getData($product_id, $language_id){
		return $this->getProductFromDb($product_id, $language_id);
	}
	
	// returns product data which is an attribute of product instance
	public function getProductData(){
		return $this->product_data;
	}
	
	// returns array with languages in which product is available from db
	public function getLanguagesForExistingProduct(){
		$sql_statement = 'SELECT p.language_id FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = "'. $this->product_id .'"';
		$language_query = db_query($sql_statement);
		$language_id_array = array();
		// loops through relevant languages an writes the language ids into result array
		while($data = db_fetch_array($language_query)) {
			$language_id_array[$data['language_id']] ='';
		}
		return $language_id_array;
	}
	
	// returns array with all active products and their attributes
	public static function getAllActiveProducts($languageId){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT .' AS p WHERE language_id = "'. $languageId .'" AND active = "1" ORDER BY p.product_id ASC';
		$active_product_query = db_query($sql_select_statement);
		
		$active_product_array = array();
		
		// fills array with product data for each product
		while($data = db_fetch_array($active_product_query)){
			$active_product_array[$data['product_id']] = array("title" => $data['title'],
													   "contract_periode" => $data['contract_periode'],
													   "description" => $data['description'], 
													   "quantity" => $data['quantity'],
													   "price" => $data['price']);
		}
		return $active_product_array;
	}

	// private section
	
	private function getProductFromDb($product_id, $language_id) {
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT .' WHERE product_id = "'. (int) $product_id.'" AND language_id = "'. $language_id. '"' ;
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
	
	// returns form to edit product where fields are filled with content from db as HTML
	private function getFilledProductEditForm($language_select_box){
		$return_string = '<form name="myForm" class="form_backend">'.'<fieldset>'.
					'<legend>'.
						'<label for="product_id_notation">'. LABEL_PRODUCT_ID .' </label>'.
						'<label for="product_id">'. $this->product_id.' </label>'.
					'</legend>'.
					'<input type="hidden" id = "product_id" name = "product_id" value = '.$this->product_id.'>'.
					'<input type="hidden" id = "active" name = "active" value = '.$this->active.'>'.
					'<label for="language_id">'. LABEL_PRODUCT_LANGUAGE. '</label> '.
					$language_select_box. // dropdown box which contains these languages in which the exists in db
					'<label for="title">'. LABEL_PRODUCT_TITLE .'</label>'.
					'<input type="text" id="title" name="title" value="'. $this->title .'"><br>'.
					'<label for="contract_periode">'. LABEL_PRODUCT_CONTRACT_PEROIDE .'</label>'.
					'<input type="text" id="contract_periode" name="contract_periode" value="'. $this->contract_periode .'">'.
					'<label for="contract_periode_unit">'. LABEL_PRODUCT_CONTRACT_PEROIDE_UNIT .'</label><br>'.
					'<label for="description">'. LABEL_PRODUCT_DESCRIPTION .'</label><br>'.
					'<textarea cols="20" rows="4" id="description" name="description" >'.$this->description .'</textarea><br>'.
					'<label for="quantity">'. LABEL_PRODUCT_QUANTITY .'</label>'.
					'<input type="text" id="quantity" name="quantity" value="'. $this->quantity .'"><br>'.
					'<label for="price">'. LABEL_PRODUCT_PRICE .'</label>'.
					'<input type="text" id="price" name="price" value="'. $this->price .'"><br>';

		return $return_string;
	}
	
	// returns form to edit and refer attributes to product as HTML
	private function getAttributeEditForm($attributes_for_lang, $attr_for_product){
		$return_string = '<form>'.'<fieldset>'.
				'<legend>'.
				'<label for="product_id_notation">'. LABEL_PRODUCT_ATTRIBUTE .' </label>'.
				'<label for="product_id">'. $this->product_id.' </label>'.
				'</legend>'.
				'<input type="hidden" id = "product_id" name = "product_id" value = "'.$this->product_id .'">'.
				'<input type="hidden" id = "language_id" name = "language_id" value = "'.$this->language_id .'">';
		$attr_ids = "";
		// loops through array (attribute id -> attribute value) and print every refered attribut
		foreach($attr_for_product as $att_id=>$att_val){
			$attr_ids = $attr_ids. $att_id.',';
			$label_for_attr_description = '';
			$return_string = $return_string.
					'<input type="hidden" id = "attribute_id" name = attribute_id value = '. $att_id .'>'.
					'<label for="attribute_describtion">'. $attributes_for_lang[$att_id] .'</label>'.
					'<input type="text" id="'.$att_id.'" name="'.$att_id.'" value="'. $att_val .'">'.
					'<a href="#" id="delete_product_info" rel="'. $att_id .'"><img id="img_delete" src="'. PATH_IMAGES_REL .'delete_small.png" title="'. LINK_DELETE . '"></a><br>';
		}
		$trimmed_attr_ids = trim($attr_ids, ",");
		$return_string = $return_string. '<input type="hidden" id = "attr_array" name = "attr_array" value = '.$trimmed_attr_ids.'>';
		return $return_string;		
	}
}

?>
