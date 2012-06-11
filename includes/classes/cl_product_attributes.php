<?php
class productAttribute{
	private $product_attribute_id;
	private $language_id;
	private $describtion;
	private $product_attribute_data;
	
	public function _construct($product_attribute_id = NULL){
		if(§product_attribute_id != NULL){
			$product_attribute_data = $this->getProductData($product_id);
			$this->product_attribute_data = $product_attribute_data;
			$this->product_attribute_id = $product_attribute_data['product_attribute_id'];
			$this->language_id = $product_attribute_data['language_id'];
			$this->describtion = $product_attribute_data['describtion'];
			
		}
	}
	
	public static function create(){
		if($product_attribute_data != NULL){
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT_ATTRIBUTE .'(language_id, description)
			VALUES (
			"'. $product_attribute_data['language_id'] .'",
			"'. $product_attribute_data['describtion'] .'",)';
			db_query($sql_insert_statement);
		}
	}
	
	public function getData(){
		return $this->getProductAttributeFromDB();
	}
	
	
	/*private section*/
	private function getProductAttributeFromDB(){
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT_ATTRIBUTE .' WHERE product_attribute_id = '. (int) $product_attribute_id;
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
}
?>