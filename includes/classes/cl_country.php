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
	public function printSelectBox($selectbox_id, $name = 'country', $default_value = NULL, $additional_information = NULL) {
		$result = '<select name="'. $selectbox_id .'" id="'. $selectbox_id .'" size="1" ' .$additional_information. '>';

		if($default_value == NULL) {
			$result = $result . '<option value="" style="display:none;"></option>';
		}
		
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
	
	// returns country name for given country id
	// if no suitable country name was found return null
	public static function getCountryName($country_id, $language_id = NULL) {
		// get browser language if no language id was given
		if($language_id == NULL) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
		
		// get country name by country id and language id
		$sql_statement = 'SELECT co.country_name FROM '. TBL_COUNTRY .' AS co WHERE co.country_id = '. (int) $country_id .' AND co.language_id = '. (int) $language_id;
		$query = db_query($sql_statement);
		
		if(db_num_results($query) == 1) {
			$result = db_fetch_array($query);
			return $result['country_name'];
		}
		else {
			return null;
		}
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