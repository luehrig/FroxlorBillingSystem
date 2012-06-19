<?php
class productAttribute{
	private $product_attribute_id;
	private $language_id;
	private $description;
	private $product_attribute_data;
	
	public function _construct($product_attribute_id = NULL, $language_id = NULL){
		if($product_attribute_id != NULL AND $language_id != NULL){
			$product_attribute_data = $this->getData($product_attribute_id, $language_id);
			$this->product_attribute_data = $product_attribute_data;
			$this->product_attribute_id = $product_attribute_data['product_attribute_id'];
			$this->language_id = $product_attribute_data['language_id'];
			$this->description = $product_attribute_data['description'];
	
			
		}
	}
	
	public static function create(){
		
		//create new product_attribute
		if($product_attribute_data != NULL){
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_ATTRIBUTE .'(language_id, description)
			VALUES (
			"'. $product_attribute_data['language_id'] .'",
			"'. $product_attribute_data['description'] .'",)';
			db_query($sql_insert_statement);
		}
		
		//tanslate product_attribute
		else{
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_ATTRIBUTE .'(product_attribute_id, language_id, description)
			VALUES (
			"'. $product_attribute_data['product_attribute_id'] .'",
			"'. $product_attribute_data['language_id'] .'",
			"'. $product_attribute_data['description'] .'",)';
			db_query($sql_insert_statement);
			
		}
	}
	
	public static function printOverview($id_language_map, $container_id='product_attribute_overview'){
		
		
		$sql_statement = 'SELECT p.product_attribute_id, p.language_id, p.description FROM '. TBL_PRODUCT_ATTRIBUTE .' AS p ORDER BY p.product_attribute_id ASC';
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
			<td><a href="#" id="translate_product_attribute" rel="'. $primary_keys .'">'. LINK_TRANSLATE_PRODUCT . '</a></td>
			<td><a href="#" id="delete_product_attribute" rel="'. $primary_keys .'">'. LINK_DELETE_PRODUCT . '</a></td>
			</tr>';
		}
		$return_string = $return_string . $table_header . $table_content. '</table><br>';
		return $return_string;
		
	}
	
	public function printFormEdit($language_select_box, $language_id, $container_id = 'product_attribute_editor'){
		$return_string = '<div id="'.$container_id.'">.
							<form>'.'<fieldset>'. $language_select_box. '
							<label for="describtion">'. LABEL_DESCRIPTION .'</label><br>'. '
							<textarea cols="20" rows="4" id="description" name="description" >'. $this->description .'</textarea><br>';
							
		$return_string = $return_string . '<input type="submit" name="submit_edit_product_attribute" id="submit_edit_product_attribute" value="'. BUTTON_CHANGE_PRODUCT_ATTRIBUTE .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
	}
	
	public function getData($product_attribute_id, $language_id){
		return $this->getProductAttributeFromDB($product_attribute_id, $language_id);
	}
	
	
	/*private section*/
	private function getProductAttributeFromDB($product_attribute_id, $language_id){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE product_attribute_id ="'.  $product_attribute_id .'" AND language_id="' . $language_id . '"';
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
}
?>