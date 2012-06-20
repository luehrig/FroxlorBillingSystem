<?php
class productInfo{
	
	private $product_id;
	private $attribute_id;
	private $language_id;
	private $value;
	
	
	public function __construct($product_id = NULL, $attribute_id = NULL, $language_id = NULL){
		if($product_id != NULL AND $attribute_id != NULL AND $language_id != NULL){
			$product_info_data = $this->getData();
			$this->product_id = $product_info_data['product_id'];
			$this->attribute_id = $product_info_data['attribute_id'];
			$this->language_id = $product_info_data['language_id'];
			$this->value = $product_info_data['value'];
		}	
	}
	
	public function getData($product_id, $attribute_id, $language_id){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_INFO .' WHERE product_id = "'. (int) $product_id.'" 
																AND language_id = "'. $language_id. '"
																AND attribute_id = "'. $attribute_id .'"';
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
	
	public static function getAttributesByProductIdAndLang($product_id, $language_id){
		$attrArray = productInfo::getAttributesByProductIdAndLangFromDB($product_id, $language_id);
		return $attrArray;
	}
	
	private static function getAttributesByProductIdAndLangFromDB($product_id, $language_id){
		$attr_array = array();
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_INFO .' WHERE product_id = "'. $product_id .'"
																		AND language_id = "'. $language_id .'"';
		$attr_query = db_query($sql_select_statement);
		while($data = db_fetch_array($attr_query)){
			$attr_array[$data['attribute_id']] = $data['value'];
		}
		return $attr_array;
	}
}