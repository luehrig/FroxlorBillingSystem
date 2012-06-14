<?php

class content {
	
	private $content_id = NULL;
	private $language;
	private $title;
	private $text;
	
	/* constructor */
	public function __construct($content_id, $language = NULL) {
		// try to load specific content
		$loading_result = $this->load($content_id, $language);
		
		// if content was not able to load return null object to caller
		if($loading_result == false) {
			return NULL;
		}
	}
	
	/* public section */
	// return content title (optional in other language)
	public function getTitle($language = NULL) {
		if($this->content_id != NULL) {
			// load title in other language
			if($language != NULL) {
				$sql_statement = 'SELECT c.title FROM '. TBL_CONTENT .' AS c WHERE c.content_id = '. (int) $this->content_id .' AND c.language_id = '. (int) $language;
			 	$title_query = db_query($sql_statement);
			 	$result_data = db_fetch_array($title_query);
			 	return $result_data['title'];
			}
			else {
				return $this->title;
			}	
		}
		else {
			return false;
		}
	}
	
	// return content text (optional in other language)
	public function getText($language = NULL) {
		if($this->content_id != NULL) {
			// load text in other language
			if($language != NULL) {
				$sql_statement = 'SELECT c.text FROM '. TBL_CONTENT .' AS c WHERE c.content_id = '. (int) $this->content_id .' AND c.language_id = '. (int) $language;
			 	$text_query = db_query($sql_statement);
			 	$result_data = db_fetch_array($text_query);
			 	return $result_data['text'];
			}
			else {
				return $this->text;
			}	
		}
		else {
			return false;
		}
	}
	
	// create content
	public static function create($title, $text, $language = NULL) {
		// if no language was given use default language from customizing
		if($language == NULL) {
			$language = get_default_language();
		}
		
		$insert_statement = 'INSERT INTO '. TBL_CONTENT .' (language_id, title, text)
							VALUES ('. (int) $language .', "'. $title .'", "'. $text .'")';
			
		db_query($insert_statement);
		$content_id = db_insert_id();
		
		// if creation was successfully return content object with new content
		if($content_id != false) {
			return new content($content_id, $language);
		}
	}
	
	// print list with all active content
	public static function printOverview($language = NULL, $container_id = 'contentoverview') {
		// return all languages
		if($language == NULL) {
			$sql_statement = 'SELECT c.content_id, c.language_id, c.title FROM '. TBL_CONTENT .' AS c';
		}
		// return only requested language
		else {
			$sql_statement = 'SELECT c.content_id, c.language_id, c.title FROM '. TBL_CONTENT .' AS c WHERE c.language_id = '. (int) $language;
		}
		
		$content_query = db_query($sql_statement);
		
		$return_string = '<div id="'. $container_id .'">';

		$return_string = $return_string . '<table><tr><th>'. TABLE_HEADING_CONTENT_TITLE .'</th></tr>';
		
		while($data = db_fetch_array($content_query)) {
			$return_string = $return_string . '<tr id="'. $data['content_id'] .'_'. $data['language_id'] .'"><td name="title" title="'. $data['content_id'] .'">'. $data['title'] .'</td><td><a href="#" id="edit_content" rel="'. $data['content_id'] .'_'. $data['language_id'] .'">editicon</a></td><td><a href="#" id="delete_content" rel="'. $data['content_id'] .'_'. $data['language_id'] .'">deleteicon</td></tr>';
		}
		
		$return_string = $return_string . '</table></div>';
		
		return $return_string;
	}
	
	// update content
	public function update($title, $text, $language) {
		if($this->content_id != NULL) {
			$update_statement = 'UPDATE '. TBL_CONTENT .' AS c SET c.title = "'. $title .'", c.text = "'. $text .'" WHERE c.content_id = '. (int) $this->content_id .' AND c.language_id = '. (int) $language;
			db_query($update_statement);
			
			// reload content in object
			$this->load($this->content_id, $language);
		}	
	}
	
	// delete content
	public function delete($language = NULL, $alllanguages = false) {
		if($this->content_id != NULL) {
			// if no language was given and object language is initialized use this one
			if($language == NULL && $this->language != NULL) {
				$language = $this->language;
			}
			
			// delete content with all languages
			if($alllanguages == true) {
				$delete_statement = 'DELETE FROM '. TBL_CONTENT .' WHERE content_id = '. (int) $this->content_id;
			}
			else {
				$delete_statement = 'DELETE FROM '. TBL_CONTENT .' WHERE content_id = '. (int) $this->content_id .' AND language_id = '. (int) $language;
			}	
			// execute delete statement
			db_query($delete_statement);
		}
		else {
			return false;
		}	
	}
	
	/* private section */
	private function load($content_id, $language = NULL) {
		// if no language was given use default language from customizing
		if($language == NULL) {
			$language = get_default_language();
		}
		
		$this->language = $language;
		$sql_statement = 'SELECT c.content_id, c.title, c.text FROM '. TBL_CONTENT .' AS c WHERE c.content_id = '. (int) $content_id .' AND c.language_id = '. (int) $language;
		$content_query = db_query($sql_statement);
		
		// content was found
		if(db_num_results($content_query) == 1) {
			$result_data = db_fetch_array($content_query);
			$this->content_id = $result_data['content_id'];
			$this->title = $result_data['title'];
			$this->text = $result_data['text'];
			
			return true;
		}
		// content does not exist in DB
		else {
			return false;
		}
	}
	
}

?>