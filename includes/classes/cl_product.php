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
			//echo $this->active;
			
		}		
	}
	/* public section */
	
	// return product title (optional in other language)
	public function getTitle($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.title FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['title'];
			}
			else {
				return $this->title;
			}
		}
		else {
			return false;
		}
	}
	
	// return contract periode (optional in other language)
	public function getContractPeriode($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.contract_periode FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['contract_periode'];
			}
			else {
				return $this->contract_periode;
			}
		}
		else {
			return false;
		}
	}
	
	// return description (optional in other language)
	public function getDescription($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.description FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['description'];
			}
			else {
				return $this->description;
			}
		}
		else {
			return false;
		}
	}
	
	// return quantity (optional in other language)
	public function getQuantity($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.quantity FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['quantity'];
			}
			else {
				return $this->quantity;
			}
		}
		else {
			return false;
		}
	}
	
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
	
	// return active (optional in other language)
	public function getActive($language = NULL) {
		if($this->product_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT p.active FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
				$title_query = db_query($sql_statement);
				$result_data = db_fetch_array($title_query);
				return $result_data['active'];
			}
			else {
				return $this->active;
			}
		}
		else {
			return false;
		}
	}
	
	
	
	
	
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
	
	public function delete($product_id, $language_id) {
		$sql_delete_statement = 'DELETE FROM '. TBL_PRODUCT .' WHERE product_id = "'. (int) $product_id.'" AND language_id = "'. $language_id. '"';
		return db_query($sql_delete_statement);
	}
	
	public function update($product_id, $language_id, $product_data) {
		if($product_data != NULL){
			$sql_update_statement = 'UPDATE '. TBL_PRODUCT .' SET
				language_id="'. $product_data['language_id'] .'", 
				title="'. $product_data['title'] .'", 
				contract_periode="'. $product_data['contract_periode'] .'", 
				description="'. $product_data['description'].'", 
				quantity="'. $product_data['quantity'] .'", 
				price="'. $product_data['price'] .'", 
				active="'. $product_data['active'] .'" 
				WHERE product_id="'. $product_id .'" AND language_id = "'. $language_id. '"' ;
			
			return db_query($sql_update_statement);
		}
	}
	

	public static function printOverview($shown_language_id, $id_language_map, $container_id = 'product_overview'){
		
		$sql_statement = 'SELECT p.product_id, p.language_id, p.title, p.contract_periode, p.description, p.quantity, p.price, p.active FROM '. TBL_PRODUCT .' AS p WHERE p.language_id="'. $shown_language_id .'" ORDER BY p.product_id ASC';
		$product_query = db_query($sql_statement);
		$number_of_products = db_num_results($product_query);
		
		
		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_PRODUCTS, $number_of_products) . '<br>';
		
		
		$create_button = '<a href="#" id="create_new_product">'.BUTTON_CREATE_NEW_PRODUCT.'</a></td>';
		
		
		$return_string = $return_string . $create_button . '<br><br>';
		
		
		$table_header = '<table border = "0">
		<tr>
		<th>'. TABLE_HEADING_PRODUCT_LANGUAGE .'</th>
		<th>'. TABLE_HEADING_PRODUCT_TITLE .'</th>
		<th>'. TABLE_HEADING_PRODUCT_CONTRACT_PERIODE.'</th>
		<th>'. TABLE_HEADING_PRODUCT_DESCRIPTION.'</th>
		<th>'. TABLE_HEADING_PRODUCT_QUANTITY .'</th>
		<th>'. TABLE_HEADING_PRODUCT_PRICE .'</th>
		</tr>';
		
		$table_content = '';
		while($data = db_fetch_array($product_query)) {
			
			$primary_keys = $data['product_id'].','.$data['language_id'];
			
			$active = $data['active'];
			$change_state;
			if($active==1){
				$change_state = LINK_DEACTIVATE_PRODUCT;
			}
			elseif($active==0){
				$change_state = LINK_ACTIVATE_PRODUCT;
			}
			$table_content = $table_content .'<tr>
			<td>'. $id_language_map[$data['language_id']] .'</td>
			<td>'. $data['title'] .'</td>
			<td>'. $data['contract_periode'] .'</td>
			<td>'. $data['description'] .'</td>
			<td>'. $data['quantity'] .'</td>
			<td>'. $data['price'] .'</td>
			<td><a href="#" id="edit_product" rel="'. $primary_keys .'">Bearbeiten-Icon</a><br>
			<a href="#" id="translate_product" rel="'. $primary_keys .'">'. LINK_TRANSLATE_PRODUCT . '</a><br>
			<a href="#" id="change_product_state" rel="'. $primary_keys .'">'. $change_state . '</a><br>
			<a href="#" id="delete_product" rel="'. $primary_keys .'">'. LINK_DELETE . '</a></td>
			</tr>';
		}
		$return_string = $return_string . $table_header . $table_content. '</table><br>';
		return $return_string;
	}
	
	public function printFormEdit($attributesForLang, $product_info, $language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">'.
		$this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_edit_product" id="submit_edit_product" value="'. BUTTON_CHANGE_PRODUCT .'">';
		$return_string = $return_string . '</form></fieldset>';
		
		$return_string = $return_string . $this->getAttributeEditForm($attributesForLang, $product_info);
		$return_string = $return_string . '<input type="submit" name="submit_edit_attributes" id="submit_edit_attributes" value="'. BUTTON_CHANGE_ATTRIBUTES .'">';
		$return_string = $return_string . '<input type="submit" name="give_prod_new_attr" id="give_prod_new_attr" value="'. BUTTON_NEW_ATTR_FOR_PROD .'">';
		$return_string = $return_string . '</form></fieldset>';
		$return_string = $return_string. '</div>';
		return $return_string;
		
	}
	
	public function printFormTranslate($language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">'.
		$this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_translate_product" id="submit_translate_product" value="'. BUTTON_CHANGE_PRODUCT .'">';
		
		$return_string = $return_string . '</form>';
		$return_string = $return_string. '</div>';
		return $return_string;
	}
	
	public function saveTranslatedProduct($product_data){
		return $this->create($product_data);
	}
	
	public function entryExists($product_data){
		return $this->productExists($product_data);
	}
	
	public static function printCreateProductForm($language_select_box, $container_id = 'new_product_editor'){
		$sql_statement = 'SELECT p.product_id, p.language_id, p.title, p.contract_periode, p.description, p.quantity, p.price FROM '. TBL_PRODUCT .' AS p ORDER BY p.title ASC';
		$product_query = db_query($sql_statement);
		$number_of_products = db_num_results($product_query);
		$new_product_id = $number_of_products + 1;
		
		$return_string = '<div id="'.$container_id.'">.
		<form method="post">'.'<fieldset>'.
		'<legend>'.
		'<label for="product_id_notation">'. LABEL_PRODUCT_ID .' </label>'.
		'<label for="product_id">'. $new_product_id.' </label>'.
		'</legend>'.
		'<label for="language_id">'. LABEL_PRODUCT_LANGUAGE. '</label> '.
		$language_select_box . 
		'<label for="title">'. LABEL_PRODUCT_TITLE .'</label>'.
		'<input type="text" id="title" name="title"><br>'.
		'<label for="contract_periode">'. LABEL_PRODUCT_CONTRACT_PEROIDE .'</label>'.
		'<input type="text" id="contract_periode" name="contract_periode"><br>'.
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
		if($db_content['product_id'] == $compareable_product_id){
			return false;
		}
		if($db_content == ""){
			return false;
		}
		else return true;
	}
	
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
	
	public function changeProductState($product_data){		
		$sql_update_statement = 'UPDATE '. TBL_PRODUCT .' SET active="' . $product_data['active'] . '" WHERE
		product_id="' . $product_data['product_id'] . '"';  
		return db_query($sql_update_statement);
	}
	
	// getter 
	
	public function getData($product_id, $language_id){
		return $this->getProductFromDb($product_id, $language_id);
	}
	
	public function getProductData(){
		return $this->product_data;
	}
	
	public function getLanguagesForExistingProduct($product_id){
		$sql_statement = 'SELECT p.language_id FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = "'. $product_id .'"';
		$language_query = db_query($sql_statement);
		$language_id_array = array();
		while($data = db_fetch_array($language_query)) {
			$language_id_array[$data['language_id']] ='';
		}
		return $language_id_array;
	}
	
	public static function getAllActiveProducts($languageId){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT .' AS p WHERE language_id = "'. $languageId .'" AND active = "1" ORDER BY p.product_id ASC';
		$active_product_query = db_query($sql_select_statement);
		
		/*
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
		
		$active_product_array = array();
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
	
	private function getFilledProductEditForm($language_select_box){
		$return_string = '<form name="myForm">'.'<fieldset>'.
					'<legend>'.
						'<label for="product_id_notation">'. LABEL_PRODUCT_ID .' </label>'.
						'<label for="product_id">'. $this->product_id.' </label>'.
					'</legend>'.
					'<input type="hidden" id = "product_id" name = "product_id" value = '.$this->product_id.'>'.
					'<input type="hidden" id = "active" name = "active" value = '.$this->active.'>'.
					'<label for="language_id">'. LABEL_PRODUCT_LANGUAGE. '</label> '.
					$language_select_box.
					'<label for="title">'. LABEL_PRODUCT_TITLE .'</label>'.
					'<input type="text" id="title" name="title" value="'. $this->title .'"><br>'.
					'<label for="contract_periode">'. LABEL_PRODUCT_CONTRACT_PEROIDE .'</label>'.
					'<input type="text" id="contract_periode" name="contract_periode" value="'. $this->contract_periode .'"><br>'.
					'<label for="description">'. LABEL_PRODUCT_DESCRIPTION .'</label><br>'.
					'<textarea cols="20" rows="4" id="description" name="description" >'.$this->description .'</textarea><br>'.
					'<label for="quantity">'. LABEL_PRODUCT_QUANTITY .'</label>'.
					'<input type="text" id="quantity" name="quantity" value="'. $this->quantity .'"><br>'.
					'<label for="price">'. LABEL_PRODUCT_PRICE .'</label>'.
					'<input type="text" id="price" name="price" value="'. $this->price .'"><br>';
					
		//$return_string = $return_string . '</fieldset>';
		return $return_string;
	}
	
	private function getAttributeEditForm($attributes_for_lang, $attr_for_product){
		$return_string = '<form>'.'<fieldset>'.
				'<legend>'.
				'<label for="product_id_notation">'. LABEL_PRODUCT_ATTRIBUTE .' </label>'.
				'<label for="product_id">'. $this->product_id.' </label>'.
				'</legend>'.
				'<input type="hidden" id = "product_id" name = product_id value = '.$this->product_id.'>';
		$attr_ids = "";
		foreach($attr_for_product as $att_id=>$att_val){
			$attr_ids = $attr_ids. $att_id.',';
			$primary_keys = $att_id.','.$this->product_id;
			$return_string = $return_string.
					'<input type="hidden" id = "attribute_id" name = attribute_id value = '. $att_id .'>'.
					'<label for="attribute_describtion">'. $attributes_for_lang[$att_id] .'</label>'.
					'<input type="text" id="'.$att_id.'" name="'.$att_id.'" value="'. $att_val .'">'.
					'<a href="#" id="delete_product_attribute" rel="'. $primary_keys .'">'. LINK_DELETE . '</a><br>';
		}
		$trimmed_attr_ids = trim($attr_ids, ",");
		$return_string = $return_string. '<input type="hidden" id = "attr_array" name = "attr_array" value = '.$trimmed_attr_ids.'>';
		return $return_string;		
	}
}

?>
