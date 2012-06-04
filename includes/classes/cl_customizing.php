<?php

class customizing {
	
	private $customzing_entries = array();
	
	/* constructor */
	public function __construct($language_id) {
		$this->getCustomzingEntries($language_id);	
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
	
	/* private section */
	
	// read language depended and language independent customizing entries from db
	private function getCustomzingEntries($language_id) {
		$sql_statement = 'SELECT cust.key, cust.value FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.language_id = '. $language_id .' OR cust.language_id IS NULL';
		$query = db_query($sql_statement);
		
		while($row = db_fetch_array($query)) {
			$this->customzing_entries[$row['key']] = $row['value'];
		}
	}
	
}

?>