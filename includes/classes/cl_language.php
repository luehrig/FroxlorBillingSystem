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
	public static function printLanguages() {
		
	}
	
	
	/* private section */
	
}

?>