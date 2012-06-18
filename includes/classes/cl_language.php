<?php

class language {
	
	private $language_id = NULL;
	
	/* constructor */
	public function __construct($language = NULL) {
		if($language == NULL) {
			$language = customizing::get_default_language();
		}
		
		$this->language_id = $language;
	}
	
	/* public section */
	public static function printLanguages($div_containerid = 'languages') {
		
		$sql_statement = 'SELECT l.language_id, l.language_name FROM '. TBL_LANGUAGE .' AS l';
		$language_query = db_query($sql_statement);
		
		if(db_num_results($language_query) != 0) {
		
			$return_string = '<div id="'. $div_containerid .'">';
		
			$return_string = $return_string .'<select id="language_selection" name="language_selection" size="1">';
		
			while($data = db_fetch_array($language_query)) {
				$return_string = $return_string .'<option id="'. $data['language_id'] .'">'. $data['language_name'] .'</option>';
			}
		
			$return_string = $return_string . '</select></div>';
		}
		else {
			return false;
		}
			
		return $return_string;
	}
	
	// get browser language that matches with "installed" languages
	public static function getBrowserLanguage() {
		$supportedLanguages = language::getSupportedLanguages();
		$langs = array();
		
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			// break up string into pieces (languages and q factors)
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
		
			if (count($lang_parse[1])) {
				// create a list like "en" => 0.8
				$langs = array_combine($lang_parse[1], $lang_parse[4]);
				 
				// set default to 1 for any without q factor
				foreach ($langs as $lang => $val) {
					if ($val === '') $langs[$lang] = 1;
				}
		
				// sort list based on value
				arsort($langs, SORT_NUMERIC);
			}
		}
		
		// look through sorted list and use first one that matches our languages
		foreach ($langs as $lang => $val) {
			if(array_key_exists($lang,$supportedLanguages)) {
				return $lang;
			}
		}
		
		// show default site or prompt for language
		language::internalToISO( customizing::get_default_language() );
	}
	
	// translate internal language id to ISO 639-1 code
	public static function internalToISO($language_id) {
		$sql_statement = 'SELECT l.iso_code FROM '. TBL_LANGUAGE .' AS l WHERE l.language_id = '. (int) $language_id;
		$query = db_query($sql_statement);
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			return $result_data['iso_code'];
		}
		else {
			return null;
		}
	}
	
	// translate ISO 639-1 code to internal language id
	public static function ISOTointernal($iso_code) {
		$sql_statement = 'SELECT l.language_id FROM '. TBL_LANGUAGE .' AS l WHERE l.iso_code = "'. $iso_code .'"';
		$query = db_query($sql_statement);
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			return $result_data['language_id'];
		}
		else {
			return null;
		}
	}
	
	/* private section */
	private static function getSupportedLanguages() {
		$sql_statement = 'SELECT l.language_id, l.iso_code FROM '. TBL_LANGUAGE .' AS l ORDER BY l.iso_code';
		$query = db_query($sql_statement);
		
		$return_array = array();
		
		while($row = db_fetch_array($query)) {
			$return_array[$row['iso_code']] = $row['language_id'];
		}
		
		return $return_array;
	}
}

?>