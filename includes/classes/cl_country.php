<?php

class country {
	
	private $available_countries;
	
	public function __construct($language_id = NULL) {
		if($language_id == NULL) {
			$language_id = get_default_language();
		}
		$this->available_countries = $this->getAllAvailableCountries($language_id);
	}
	
	// print html select box
	public function printSelectBox($selectbox_id, $name = 'country', $default_value = NULL) {
		$result = '<select name="'. $selectbox_id .'" id="'. $selectbox_id .'" size="1" rel="mandatory">';
				
		$result = $result . '<option value="" style="display:none;"></option>';
		
		
		for($i=0; $i < count($this->available_countries); $i++) {
			if($default_value != NULL && $this->available_countries[$i]['country_id'] == $default_value) {
				$result = $result . '<option id="'. $this->available_countries[$i]['country_id'] .'" name="'. $name .'" selected>'. $this->available_countries[$i]['country_name'] . '</option>';
			}
			else {
				$result = $result . '<option id="'. $this->available_countries[$i]['country_id'] .'" name="'. $name .'">'. $this->available_countries[$i]['country_name'] . '</option>';
			}
		}
		
		$result = $result . '</select>';
		
		return $result;
	}
	
	// read all countries for selected language
	private function getAllAvailableCountries($language_id) {
		$sql_statement = 'SELECT country_id, iso_code, country_name FROM '. TBL_COUNTRY .' WHERE language_id = '. $language_id;
		$query = db_query($sql_statement);
		$result_array = array();
		
		while($row = db_fetch_array($query)) {
			array_push($result_array, $row);
		}
		
		return $result_array;
	}
	
}

?>