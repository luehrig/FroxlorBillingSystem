<?php

class invoice_status {

	private $description;
	private $language;
	
	/* constructor */
	public function __construct($invoice_status_id, $language = NULL) {
		// read default language from customizing if no language id was given
		if($language == null) {
			$language = $language::ISOTointernal( $language::getBrowserLanguage() );
		}
		
		// try to load invoice status from DB
		$loading_result = $this->load($invoice_status_id, $language);
		
		// if invoice status was unable to load return null object to caller
		if($loading_result == false) {
			return NULL;
		}
	}
	
	
	/* public section */
	public static function getInvoiceStatuses($language = NULL) {
		// if no language was given use default language from customizing
		if($language == NULL) {
			$language = customizing::get_default_language();
		}

		$sql_statement = 'SELECT is.invoice_status_id, is.description FROM '. TBL_INVOICE_STATUS .' AS is WHERE is.language_id = '. (int) $language;
		$query = db_query($sql_statement);

		// append single status to status array in object
		$invoice_statuses = array();

		while($row = db_fetch_array($query)) {
			array_push($invoice_statuses, $row);
		}

		return $invoice_statuses;
	}
	
	
	// TODO: to be implemented in second release
	public function update($description, $language) {
		
	}
	
	public function delete($language = NULL, $alllanguages = false ) {
		
	}
	
	public static function create($description, $language) {
		
	}
	
	
	/* private section */
	private function load($invoice_status_id, $language) {
		$sql_statement = 'SELECT is.description FROM '. TBL_INVOICE_STATUS .' AS is WHERE is.invoice_status_id = '. (int) $invoice_status_id .' AND is.language_id = '. (int) $language;
		$query = db_query($sql_statement);

		// invoice status was found
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			$this->description = $result_data['description'];
			$this->language = $language;
		}
		// invoice status does not exist in DB
		else {
			return false;
		}
	}

}

?>