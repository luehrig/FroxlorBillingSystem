<?php
class productInfo{
	
	private $product_id;
	private $attribute_id;
	private $value;
	
	
	public function __construct($product_id = NULL, $attribute_id = NULL){
		if($product_id != NULL AND $attribute_id != NULL){
			$product_info_data = $this->getData($product_id, $attribute_id);
			$this->product_id = $product_info_data['product_id'];
			$this->attribute_id = $product_info_data['attribute_id'];
			$this->value = $product_info_data['value'];
		}	
	}
	
// 	/*public section*/
// 	// return product title (optional in other language)
// 	public function getTitle($language = NULL) {
// 		if($this->product_id != NULL) {
// 			// load title in other language
// 			if($language != NULL) {
// 				$sql_statement = 'SELECT p.title FROM '. TBL_PRODUCT .' AS p WHERE p.product_id = '. (int) $this->product_id .' AND p.language_id = '. (int) $language;
// 				$title_query = db_query($sql_statement);
// 				$result_data = db_fetch_array($title_query);
// 				return $result_data['title'];
// 			}
// 			else {
// 				return $this->title;
// 			}
// 		}
// 		else {
// 			return false;
// 		}
// 	}
	
	
	public static function create($product_id, $attribute_id, $value){
		$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_INFO .' (product_id, attribute_id, value)
				VALUES (
				"'. $product_id .'",
				"'. $attribute_id .'",
				"'. $value .'")';
		return db_query($sql_insert_statement);
	}
	
	public function delete(){
		if($this->product_id != NULL AND $this->attribute_id != NULL){
			$sql_delete_statement = 'DELETE FROM '. TBL_PRODUCT_INFO .' WHERE product_id = "'. (int) $this->product_id.'" AND attribute_id = "'. $this->attribute_id. '"';
			return db_query($sql_delete_statement);
		}
		else return false;
		
	}
		
	public function getData($product_id, $attribute_id){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_INFO .' WHERE product_id = "'. (int) $product_id.'" 
																		AND attribute_id = "'. $attribute_id .'"';
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
	
	public static function getAttributesByProductId($product_id){
		$attrArray = productInfo::getAttributesByProductIdAndLangFromDB($product_id);
		return $attrArray;
	}
	
	public static function printNewAttributeForm($product_id, $availible_attributes, $container_id = 'new_attribute_for_product_editor'){
		$return_string = '<div id="'.$container_id.'">';
		$return_string = $return_string. '<form>'.'<fieldset>'.
				'<input type="hidden" id = "product_id" name = product_id value = '.$product_id.'>'.
				//'<input type="hidden" id = "language_id" name = language_id value = '.$language_id.'>'.
				'<label for="label_attribute">'. LABEL_ATTRIBUTE .' </label>'.
				'<select id="attribute_selection" name="attribute_selection" size="1">';
				if(count($availible_attributes)!=0){
					foreach ($availible_attributes as $attribute_id => $description){
						$return_string = $return_string. '<option id="'. $attribute_id .'">'. $description .'</option>';
					}
				}
				$return_string = $return_string . '</select>';
				$return_string = $return_string .
						'<label for="value">'. LABEL_VALUE .' </label>'.
						'<input type="text" id="value" name="value" value=""><br>'.
						'</fieldset>'.
						'<input type="submit" name="save_new_attr_for_prod" id="save_new_attr_for_prod" value="'. BUTTON_SAVE_ATTR_FOR_PROD .'">';
				$return_string = $return_string. '</form></div>';
				return $return_string;
				
	}
	
	public static function getAvailableAttributes($product_id, $existing_attributes_for_lang){
		$attributes_not_in_use = array();
		$current_attributes = productInfo::getAttributesByProductIdAndLangFromDB($product_id);
		foreach($existing_attributes_for_lang as $product_attribute_id=>$description){
			if(!array_key_exists($product_attribute_id, $current_attributes)){
				$attributes_not_in_use[$product_attribute_id] = $existing_attributes_for_lang[$product_attribute_id];
			}
		}
		return $attributes_not_in_use;
		
	}
	
	// private section
	private static function getAttributesByProductIdAndLangFromDB($product_id){
		$attr_array = array();
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_INFO .' WHERE product_id = "'. $product_id .'"';
		$attr_query = db_query($sql_select_statement);
		while($data = db_fetch_array($attr_query)){
			$attr_array[$data['attribute_id']] = $data['value'];
		}
		return $attr_array;
	}
}