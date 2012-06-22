<?php

class currency {
	
	private $currency_id;
	private $title;
	private $code;
	private $symbol;
	private $decimal_point;
	private $thousands_point;
	private $decimal_places;
	
	/* constructor */
	public function __construct($currency_id) {
		
		$this->currency_id = $currency_id;
		
		$this->load();
		
	}
	
	/* public section */
	public function getCurrencySign() {
		return $this->symbol;
	}
	
	
	/* private section */
	private function load() {
		$sql_statement = 'SELECT c.title, c.code, c.symbol, c.decimal_point, c.thousands_point, c.decimal_places FROM '. TBL_CURRENCY .' AS c WHERE c.currency_id = '. (int) $this->currency_id;
		$query = db_query($sql_statement);
		
		if($query != NULL) {
			$result_data = db_fetch_array($query);
		
			$this->title = $result_data['title'];
			$this->code = $result_data['code'];	
			$this->symbol = $result_data['symbol'];
			$this->decimal_point = $result_data['decimal_point'];
			$this->thousands_point = $result_data['thousands_point'];
			$this->decimal_places = $result_data['decimal_places'];
			
		}
		else {
			return NULL;
		}
	}	
	
}


?>