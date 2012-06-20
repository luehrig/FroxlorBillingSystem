<?php

class product {
	
	private $product_id;
	private $language_id;
	private $title;
	private $contract_periode;
	private $description;
	private $quantity;
	private $price;
	private $state;
	private $product_attributes;
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
				$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT .' (product_id, language_id, title, contract_periode, description, quantity, price)
				VALUES (
				"'. $product_data['product_id'] .'",
				"'. $product_data['language_id'] .'",
				"'. $product_data['title'] .'",
				"'. $product_data['contract_periode'] .'",
				"'. $product_data['description'] .'",
				"'. $product_data['quantity'] .'",
				"'. $product_data['price'] .'")';
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
			
			$state = $data['active'];
			$change_state;
			if($state==1){
				$change_state = LINK_DEACTIVATE_PRODUCT;
			}
			elseif($state==0){
				$change_state = LINK_ACTIVATE_PRODUCT;
			}
			$table_content = $table_content .'<tr>
			<td>'. $data['language_id'] .'</td>
			<td>'. $data['title'] .'</td>
			<td>'. $data['contract_periode'] .'</td>
			<td>'. $data['description'] .'</td>
			<td>'. $data['quantity'] .'</td>
			<td>'. $data['price'] .'</td>
			<td><a href="#" id="edit_product" rel="'. $primary_keys .'">Bearbeiten-Icon</a></td>
			<td><a href="#" id="translate_product" rel="'. $primary_keys .'">'. LINK_TRANSLATE_PRODUCT . '</a></td>
			<td><a href="#" id="change_product_state" rel="'. $primary_keys .'">'. $change_state . '</a></td>
			<td><a href="#" id="delete_product" rel="'. $primary_keys .'">'. LINK_DELETE_PRODUCT . '</a></td>
			</tr>';
		}
		$return_string = $return_string . $table_header . $table_content. '</table><br>';
		return $return_string;
	}
	
	public function printFormEdit($language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">.
				<form>'.'<fieldset>'. $this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_edit_product" id="submit_edit_product" value="'. BUTTON_CHANGE_PRODUCT .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
		
	}
	
	public function printFormTranslate($language_select_box, $container_id = 'product_editor'){
		$return_string = '<div id="'.$container_id.'">.
		<form>'.'<fieldset>'. $this->getFilledProductEditForm($language_select_box);
		$return_string = $return_string . '<input type="submit" name="submit_translate_product" id="submit_translate_product" value="'. BUTTON_CHANGE_PRODUCT .'">';
		$return_string = $return_string . '</form></div>';
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
		product_id="' . $product_data['product_id'] . '" AND language_id="' . $product_data['language_id']  . '"';  
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

	// private section
	
	private function getProductFromDb($product_id, $language_id) {
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT .' WHERE product_id = "'. (int) $product_id.'" AND language_id = "'. $language_id. '"' ;
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
	
	private function getFilledProductEditForm($language_select_box){
		$return_string = '<form>'.'<fieldset>'.
					'<legend>'.
						'<label for="product_id_notation">'. LABEL_PRODUCT_ID .' </label>'.
						'<label for="product_id">'. $this->product_id.' </label>'.
					'</legend>'.
					'<input type="hidden" id = "product_id" name = product_id value = '.$this->product_id.'>'.
					'<label for="language_id">'. LABEL_PRODUCT_LANGUAGE. '</label> '.
					$language_select_box.
					'<label for="title">'. LABEL_PRODUCT_TITLE .'</label>'.
					'<input type="text" id="title" name="title" value="'. $this->title .'"><br>'.
					'<label for="contract_periode">'. LABEL_PRODUCT_CONTRACT_PEROIDE .'</label>'.
					'<input type="text" id="contract_periode" name="contract_periode" value="'. $this->contract_periode .'"><br>'.
					'<label for="describtion">'. LABEL_PRODUCT_DESCRIPTION .'</label><br>'.
					'<textarea cols="20" rows="4" id="description" name="description" >'.$this->description .'</textarea><br>'.
					'<label for="quantity">'. LABEL_PRODUCT_QUANTITY .'</label>'.
					'<input type="text" id="quantity" name="quantity" value="'. $this->quantity .'"><br>'.
					'<label for="price">'. LABEL_PRODUCT_PRICE .'</label>'.
					'<input type="text" id="price" name="price" value="'. $this->price .'"><br>';
		
		$return_string = $return_string . '</fieldset>';
		return $return_string;
	}
}

?>
