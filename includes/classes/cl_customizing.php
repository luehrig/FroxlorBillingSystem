<?php

class customizing {
	
	private $customzing_entries = array();
	private $language;
	
	/* constructor */
	public function __construct($language_id = NULL) {
		if($language_id == NULL) {
			$language_id = customizing::get_default_language();
		}
		$this->getCustomzingEntries($language_id);
		$this->language = $language_id;	
	}
	
	/* public section */
	// returns all loaded customizing entries
	public function getCustomizingComplete() {
		return $this->customzing_entries;
	}
	
	// returns customizing value for given customizing entry
	public function getCustomizingValue($customizing_entry) {
		
		if( array_key_exists($customizing_entry, $this->customzing_entries) == true) {
			return $this->customzing_entries[$customizing_entry];
		}
		else {
			return NULL;
		}
	}
	
	// return default language id in internal format
	public static function get_default_language() {
		$sql_statement = 'SELECT cust.value AS default_language FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "default_language"';
		$query = db_query($sql_statement);
		$default_language = db_fetch_array($query);
	
		return $default_language['default_language'];
	}
	
	// display customizing entries table like with readonly input fields
	public function printCustomizingEntries($div_container_id = 'customizing_entries', $div_single_entry_id = 'customizing_entry') {

		$return_string = '<div id="'. $div_container_id .'">';

		while (list($key,$value) = each($this->customzing_entries)) {
			$return_string = $return_string . '<div id="' . $div_single_entry_id .'"><label for="'. $key .'">'. $key .'</label><input type="text" id="'. $key .'" readonly="readonly" value="'. $value .'"/>';
		}
		
		$return_string = $return_string . '</div>';
		$return_string = $return_string . '<input type="hidden" id="language" value="'. $this->language .'">';
		
		return $return_string;
	}
	
	// save one customizing entry
	public function saveEntry($key, $value, $language) {		
		// check if entry is language dependent
		$sql_statement = 'SELECT language_id FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "'. $key .'"';
		$query_result = db_query($sql_statement);
		
		$result_set = db_fetch_array($query_result);
		
		// customizing entry is language dependent
		if($result_set['language_id'] != '') {
			$update_statement = 'UPDATE '. TBL_CUSTOMIZING .' AS cust SET cust.value = "'. $value .'" WHERE cust.key = "'. $key .'" AND cust.language_id = '. (int) $language;
		}
		// entry is language independent
		else {
			$update_statement = 'UPDATE '. TBL_CUSTOMIZING .' AS cust SET cust.value = "'. $value .'" WHERE cust.key = "'. $key .'"';
		}
		
		db_query($update_statement);
	}
	
	/* private section */
	
	// read language depended and language independent customizing entries from db
	private function getCustomzingEntries($language_id) {
		$sql_statement = 'SELECT cust.key, cust.value FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.language_id = "'. $language_id .'" OR cust.language_id IS NULL';
		$query = db_query($sql_statement);
		
		while($row = db_fetch_array($query)) {
			$this->customzing_entries[$row['key']] = $row['value'];
		}
	}
	
}

?>