<?php

class language {
	
	private $language_id = NULL;
	
	/* constructor */
	public function __construct($language = NULL) {
		if($language == NULL) {
			$language = get_default_language();
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
	
	
	/* private section */
	
}

?>