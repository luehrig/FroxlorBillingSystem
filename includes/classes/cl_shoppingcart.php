<?php

class shoppingcart {
	
	private $session_id;
	private $create_date;
	private $products;
	private $product_counter;
	
	/* constructor */
	public function __construct($session_id, $language_id = NULL) {
		
	}
	
	public function getProducts($language_id = NULL) {
		// read default language from customizing if no language id was given
		if($language_id == null) {
			$language_id = get_default_language();
		}
		$sql_statement = 'SELECT sc.product_id, p.title, p.quantity FROM '. TBL_SHOPPING_CART .' INNER JOIN '. TBL_PRODUCT .' WHERE language_id = '. $language_id;
		$query = db_query($sql_statement);
		$this->products = db_fetch_result($query);
		$this->product_counter = db_num_results($query);
	}
}

?>