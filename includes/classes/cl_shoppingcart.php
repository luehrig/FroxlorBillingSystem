<?php

class shoppingcart {
	
	private $session_id;
	private $products;
	private $product_counter;
	
	/* constructor */
	public function __construct($session_id, $language_id = NULL) {
		$this->session_id = $session_id;
		$this->loadProducts($language_id);
		
	}
	
	/* pulic section */
	// get products array
	public function getProducts() {
		return $this->products;
	}
	
	// add given product to shopping cart (default quantity = 1)
	public function addProduct($product_id, $quantity = 1) {
		// check if given quantity is greater than 1. If not: return false!
		if($quantity >= 1) {
			// check if product is already in cart
			$check_result = $this->productExists($product_id);
		
			// product is already in shopping cart
			// just update quantity
			if($check_result != false ) {
				$update_statement = 'UPDATE '. TBL_SHOPPING_CART .' AS sc SET sc.quantity = sc.quantity + '. $quantity .' WHERE sc.session_id = "'. $this->session_id .'" AND sc.product_id = '. (int) $product_id;
				db_query($update_statement);
			}
			// product does not exist in shopping cart -> add entry now
			else {
				$insert_statement = 'INSERT INTO '. TBL_SHOPPING_CART .' (session_id, product_id, quantity) VALUES ("'. $this->session_id .'", '. (int) $product_id .', '. (int) $quantity .')';
				db_query($insert_statement);
			}
		}
		else {
			return false;
		}	 
		
		$this->loadProducts();
	}
	
	// remove product from shopping cart
	public function removeProduct($product_id, $quantity = NULL) {
		// check that quantity is greater than 0 (we do NOT delete a negative quantity which would cause in adding a product)
		if($quantity > 0 || $quantity == NULL) {
			// check if product exists in shopping cart
			$check_result = $this->productExists($product_id);
		
			// product exists in shopping cart and cart quantity is greater than quantity that should be deleted 
			// OR product exists and no quantity was given (which means whole product should be deleted)
			if($check_result != false && $check_result >= $quantity || $check_result != false && $quantity == NULL) {
				// delete products with given quantity (if quantity is greater than whole quantity of product)
				if($quantity != NULL && $check_result > $quantity) {
					$delete_statement = 'UPDATE '. TBL_SHOPPING_CART .' AS sc SET sc.quantity = sc.quantity - '. $quantity .' WHERE sc.session_id = "'. $this->session_id .'" AND sc.product_id = '. (int) $product_id;
				}
				else {
					$delete_statement = 'DELETE FROM '. TBL_SHOPPING_CART .' WHERE session_id = "'. $this->session_id .'" AND product_id = '. (int) $product_id;
				}
				db_query($delete_statement);
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
		
		$this->loadProducts();
	}
	
	// returns number of products in shopping cart
	public function getNumberOfProducts() {
		if(!$this->isEmpty()) { 
			$sql_statement = 'SELECT SUM( sc.quantity ) AS number_of_products FROM '. TBL_SHOPPING_CART .' AS sc WHERE sc.session_id = "'. $this->session_id .'"';
			$productcount_query = db_query($sql_statement);
			$result_data = db_fetch_array($productcount_query);
			return $result_data['number_of_products'];
		}
		else {
			return 0;
		}
	}
	
	// returns shopping cart as html form with table
	public function printCart($language_id = NULL, $display_checkout = false) {
		
		// read default language from customizing if no language id was given
		if($language_id == null) {
			$language_id = get_default_language();
		}
		
		$sql_statement = 'SELECT sc.product_id, sc.quantity, p.title, p.price, (sc.quantity * p.price) AS amount FROM '. TBL_SHOPPING_CART .' AS sc INNER JOIN '. TBL_PRODUCT .' AS p ON sc.product_id = p.product_id WHERE sc.session_id = "'. $this->session_id .'" AND p.language_id = '. $language_id;
		$query = db_query($sql_statement);
		
		$return_string = '<form id="shoppingcart" class="shoppingcart">
							<table rules="groups">
								<tr>
									<th>'. HEADING_PRODUCT .'</th>
									<th>'. HEADING_QUANTITY .'</th>
									<th>'. HEADING_AMOUNT .'</th>
									<th></th>
								</tr>';
		
		while($result_data = db_fetch_array($query)) {
			$return_string = $return_string .'<tr><td>'. $result_data['title'] .'</td><td><span id="decrease_'. $result_data['product_id'] .'"><img class="img_plus_minus" src="images/minus.png"></span><input type="text" id="quantity_'. $result_data['product_id'] .'" value="'. $result_data['quantity'] .'"><span id="increase_'. $result_data['product_id'] .'"><img class="img_plus_minus" src="images/plusicon.png"></span></td>
			<td><span id="amount_'. $result_data['product_id'] .'">'. $result_data['amount'] .'</span></td><td><a href="#" id="removeproduct_'. $result_data['product_id'] .'" rel="'. $result_data['product_id'] .'"><img src="images/delete.png" title="'. IMG_TITEL_REMOVE .'"></a></td></tr>';
		}
		
		//for($i=0; $i < count($this->products); $i++) {
		//	$return_string = $return_string .'<tr><td>'. $this->products[$i]['title'] .'</td><td>'. $this->products[$i]['quantity'] .'</td></tr>';
		//}
		
		$return_string = $return_string .'</table></form>';
		
		$return_string = $return_string .'<div id="buttons">';
											if($display_checkout == true) {
												$return_string = $return_string .'<a href="checkout_step1.html" id="start_checkout">'. BUTTON_CHECKOUT .'</a>';
											}	
		$return_string = $return_string .'</div>';
		
		return $return_string;
	}
	
	// clear shopping cart for expired session
	public static function deleteCart($session_id) {
		$delete_statement = 'DELETE FROM '. TBL_SHOPPING_CART .' WHERE session_id = "'. $session_id .'"';
		db_query($delete_statement);
	}
	
	/* private section */
	// load all products from shopping cart
	private function loadProducts($language_id = NULL) {
		// read default language from customizing if no language id was given
		if($language_id == null) {
			$language_id = get_default_language();
		}
		$sql_statement = 'SELECT sc.product_id, sc.quantity, p.price, p.title FROM '. TBL_SHOPPING_CART .' AS sc INNER JOIN '. TBL_PRODUCT .' AS p ON sc.product_id = p.product_id WHERE sc.session_id = "'. $this->session_id .'" AND p.language_id = '. $language_id;
		$query = db_query($sql_statement);
		
		// append single products to products array in object
		$this->products = array();
		
		while($row = db_fetch_array($query)) {
			array_push($this->products, $row);
		}
		
		$this->product_counter = db_num_results($query);
	}
	
	// check if shopping cart is empty
	private function isEmpty() {
		$sql_statement = 'SELECT sc.product_id FROM '. TBL_SHOPPING_CART .' AS sc WHERE sc.session_id = "'. $this->session_id .'"';
		$cart_products_query = db_query($sql_statement);
		// no products in cart -> empty
		if(db_num_results($cart_products_query) == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// check if product exists in shopping cart
	// If product exists in cart return quantity for product
	private function productExists($product_id) {
		$sql_statement = 'SELECT sc.quantity FROM '. TBL_SHOPPING_CART .' AS sc WHERE sc.session_id = "'. $this->session_id .'" AND sc.product_id = '. (int) $product_id;
		$productincart_query = db_query($sql_statement);
		
		// product was found in shopping cart
		if(db_num_results($productincart_query) == 1) {
			$check_result = db_fetch_array($productincart_query);
			return $check_result['quantity'];
		}
		// products does not exist in shopping cart!
		else {
			return false;
		}
	}
	
}

?>