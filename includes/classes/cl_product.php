<?php

class product {
	
	private $product_id;
	private $language_id;
	private $title;
	private $contract_periode;
	private $describtion;
	private $quantity;
	private $price;
	private $product_data;
	
	/* constructor */
	public function __construct($product_id = NULL) {
		if($product_id != NULL){
			$product_data = $this->getProductData($product_id);
			$this->product_data = $product_data;
			$this->product_id = $product_data['product_id'];
			$this->language_id = $product_data['language_id'];
			$this->title = $product_data['title'];
			$this->contract_periode = $product_data['contract_periode'];
			$this->describtion = $product_data['description'];
			$this->quantity = $product_data['quantity'];
			$this->price = $product_data['price'];
		}	
		
	}
	
	
	/* public section */
	
	public static function create($product_data) {
		if($product_data != NULL){
			$sql_insert_statement = 'INSERT INTO '. TBL_PRODUCT .'(language_id, title, contract_periode, description, quantity, price)
			VALUES (
			"'. $product_data['language_id'] .'",
			"'. $product_data['title'] .'",
			"'. $product_data['contract_periode'] .'",
			"'. $product_data['describtion'] .'",
			"'. $product_data['quantity'] .'",
			"'. $product_data['price'] .'")';
			db_query($sql_insert_statement);
		}
	}
	 
	public function deleteProduct($product_id) {
		$sql_delete_statement = 'DELETE FROM'. TBL_PRODUCT .'WHERE product_id = '. (int) $product_id;
		db_query($sql_delete_statement);
	}
	
	public function updateProduct($product_id, $product_data) {
		if($product_data != NULL){
			$sql_delete_statement = 'UPDATE'. TBL_PRODUCT .'SET
				language_id='. $product_data['language_id'] .', 
				title='. $product_data['title'] .', 
				contract_periode='. $product_data['contract_periode'] .', 
				describtion='. $product_data['describtion']. ', 
				quantity='. $product_data['quantity'] .', 
				price='. $product_data['price'] .'
				WHERE product_id="'. $product_data['product_id'] .'"';
			
			db_query($sql_delete_statement);
		}
	}
	
	public function getProductData($product_id){
		return $this->getProductFromDb($product_id);
	}
	
	
	/*private section*/
	
	private function getProductFromDb($product_id) {
		$sql_select_statement = 'SELECT * FROM '. TBL_PRODUCT .' WHERE product_id = '. (int) $product_id;
		$info_query = db_query($sql_select_statement);
		return db_fetch_array($info_query);
	}
	
}

?>