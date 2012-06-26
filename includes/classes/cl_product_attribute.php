<?php
class productAttribute{
	private $product_attribute_id;
	private $language_id;
	private $description;
	private $product_attribute_data;
	
	public function __construct($product_attribute_id = NULL, $language_id = NULL){
		if($product_attribute_id != NULL AND $language_id != NULL){
			$product_attribute_data = $this->getData($product_attribute_id, $language_id);
			$this->product_attribute_data = $product_attribute_data;
			$this->product_attribute_id = $product_attribute_data['product_attribute_id'];
			$this->language_id = $product_attribute_data['language_id'];
			$this->description = $product_attribute_data['description'];	
		}
	}
	
	
	
	public static function create($product_attribute_data){
		
		//create new product_attribute
		if($product_attribute_data['product_attribute_id'] == NULL){
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_ATTRIBUTE .'(language_id, description)
			VALUES (
			"'. $product_attribute_data['language_id'] .'",
			"'. $product_attribute_data['description'] .'")';
			return db_query($sql_insert_statement);
		}
		
		//tanslate product_attribute
		else{
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_ATTRIBUTE .'(product_attribute_id, language_id, description)
			VALUES (
			"'. $product_attribute_data['product_attribute_id'] .'",
			"'. $product_attribute_data['language_id'] .'",
			"'. $product_attribute_data['description'] .'")';
			return db_query($sql_insert_statement);
			
		}
	}
	
	public function delete(){
		
	}
	
	public function update($change_description){
		if($change_description != NULL){
			$sql_update_statement = 'UPDATE '. TBL_PRODUCT_ATTRIBUTE .' SET 
				description = "'. $change_description .'" WHERE product_attribute_id = "'.$this->product_attribute_id.'" AND language_id="'.$this->language_id.'"'; 
			return db_query($sql_update_statement);
		}
		
	}

	public static function printOverview($shown_language_id, $id_language_map, $container_id='product_attribute_overview'){
		
		
		$sql_statement = 'SELECT p.product_attribute_id, p.language_id, p.description FROM '. TBL_PRODUCT_ATTRIBUTE .' AS p WHERE p.language_id = "'. $shown_language_id .'" ORDER BY p.product_attribute_id ASC';
		$product_attribute_query = db_query($sql_statement);
		$number_of_product_attributes = db_num_results($product_attribute_query);
		
		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_PRODUCT_ATTRIBUTES, $number_of_product_attributes). '<br>';
		
		
		$create_button = '<a href="#" id="create_new_product_attribute">'.BUTTON_CREATE_NEW_PRODUCT_ATTRIBUTE.'</a></td>';
		
		
		$return_string = $return_string . $create_button . '<br><br>';
		
		
		$table_header = '<table border = "0">
		<tr>
		<th>'. TABLE_HEADING_PRODUCT_ATTRIBUTE_LANGUAGE .'</th>
		<th>'. TABLE_HEADING_PRODUCT_ATTRIBUTE_DESCRIPTION .'</th>
		</tr>';
		
		$table_content = '';
		while($data = db_fetch_array($product_attribute_query)) {
				
			$primary_keys = $data['product_attribute_id'].','.$data['language_id'];
				
			$table_content = $table_content .'<tr>
			<td>'. $id_language_map[$data['language_id']] .'</td>
			<td>'. $data['description'] .'</td>
			<td><a href="#" id="edit_product_atrribute" rel="'. $primary_keys .'">Bearbeiten-Icon</a></td>
			<td><a href="#" id="delete_product_attribute" rel="'. $primary_keys .'">'. LINK_DELETE . '</a></td>
			</tr>';
		}
		$return_string = $return_string . $table_header . $table_content. '</table><br>';
		return $return_string;
	}
	
	public static  function printCreateAttributeForm($language_select_box, $container_id = 'new_product_form'){
		$return_string = '<div id="'.$container_id.'">'.
		'<form>'.'<fieldset>'.
		'<label for="language_id">'. LABEL_PRODUCT_ATTRIBUTE_LANGUAGE .'</label><br> '.
		$language_select_box.
		'<label for="description">'. LABEL_PRODUCT_ATTRIBUTE_DESCRIPTION .'</label><br>'.
		'<textarea cols="20" rows="4" id="description" name="description" > </textarea><br>';
		$return_string = $return_string . '<input type="submit" name="create_product_attribute" id="create_product_attribute" value="'. BUTTON_CREATE_PRODUCT_ATTRIBUTE .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
	}
	
	public static function productAttributeExists($product_attribute_data, $compareable_product_attribute_id){

		$sql_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE
		language_id = "'. $product_attribute_data['language_id'] .'" AND
		description = "'. $product_attribute_data['description'] .'"';
		$info_query = db_query($sql_statement);
		$db_content = db_fetch_array($info_query);
		if($db_content['product_attribute_id'] == $compareable_product_attribute_id){
			return false;
		}
		if($db_content == ""){
			return false;
		}
		else return true;
	}
	
	
	
	public function getData($product_attribute_id, $language_id){
		return $this->getProductAttributeFromDB($product_attribute_id, $language_id);
	}
	
	public function getLanguagesForExistingProductAttr($product_attribute_id){
		$sql_select_statement = 'SELECT p.language_id FROM '. TBL_PRODUCT_ATTRIBUTE .' AS p WHERE p.product_attribute_id = "'. $product_attribute_id .'"';
		$language_query = db_query($sql_select_statement);
		$language_id_array = array();
		while($data = db_fetch_array($language_query)) {
			$language_id_array[$data['language_id']] ='';
		}
		return $language_id_array;
	}
	
	public function printFormEdit($language_select_box, $language_id, $container_id = 'product_attribute_editor'){
		$return_string = '<div id="'.$container_id.'">.
		<form>'.'<fieldset>'. 
			'<input type="hidden" id = "product_attribute_id" name = product_attribute_id value = '.$this->product_attribute_id.'>'.
			'<label for="language_id">'. LABEL_PRODUCT_ATTRIBUTE_LANGUAGE .'</label><br> '.
				$language_select_box.
			'<label for="description">'. LABEL_PRODUCT_ATTRIBUTE_DESCRIPTION .'</label><br>'.
			'<textarea cols="20" rows="4" id="description" name="description" >'.$this->description .'</textarea><br>';
		$return_string = $return_string . '<input type="submit" name="submit_edit_product_attribute" id="submit_edit_product_attribute" value="'. BUTTON_CHANGE_PRODUCT_ATTRIBUTE .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
	}
	
	public static function getAllExistingAttrByLang($language_id){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE language_id = "'. $language_id .'"';
		$attribute_query = db_query($sql_select_statement);
		$attribute_array = array();
		while($data = db_fetch_array($attribute_query)){
			$attribute_array[$data['product_attribute_id']] = $data['description'];
		}
		return $attribute_array;
	}
	
	public static function descriptionAlreadyExists($language_id, $description){
		$exists = false;
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE language_id = "'.$language_id.'" AND description = "'.$description.'"';
		$info_query = db_query($sql_select_statement);
		if(db_num_results($info_query) == 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	/*private section*/
	private function getProductAttributeFromDB($product_attribute_id, $language_id){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE product_attribute_id ="'.  $product_attribute_id .'" AND language_id="' . $language_id . '"';
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
}
?>
