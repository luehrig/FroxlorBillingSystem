<?php

class notice {

	private $notice_id;
	private $contract_id;
	private $termination_date;

	/* constructor */
	public function __construct($notice_id) {
		$this->notice_id = (int) $notice_id;

		$this->load();
	}

	/* public section */
	// getter
	public function getContractID() {
		return $this->contract_id;
	}

	public function getTerminationDate() {
		return $this->termination_date;
	}

	public function getExecutionDate() {
		$contract = new contract($this->contract_id);
		
		return $contract->getExpirationDate();
	}
	
	// delete notice
	public function delete() {
		$sql_statement = 'DELETE FROM '. TBL_NOTICE .' WHERE notice_id = '. (int) $this->notice_id;
		db_query($sql_statement);
	}
	
	// create new notice for contract
	public static function create($contract_id, $termination_date = NULL) {
		// use current date for termination date
		if($termination_date == NULL) {
			$sql_statement = 'INSERT INTO '. TBL_NOTICE .' (contract_id, termination_date) VALUES ('. (int) $contract_id .', NOW() )';
		}
		// use termination date that was given
		else {
			$sql_statement = 'INSERT INTO '. TBL_NOTICE .' (contract_id, termination_date) VALUES ('. (int) $contract_id .', '. $termination_date .')';
		}

		db_query($sql_statement);

		$notice_id = db_insert_id();

		if($notice_id != NULL) {
			return new notice( $notice_id );
		}
		else {
			return NULL;
		}
	}


	/* private function */
	// load information about notice
	private function load() {
		$sql_statement = 'SELECT no.contract_id, no.termination_date FROM '. TBL_NOTICE .' AS no WHERE no.notice_id = '. (int) $this->notice_id;
		$query = db_query($sql_statement);

		if(db_num_results($query) == 1) {
			$data = db_fetch_array($query);
				
			$this->contract_id = $data['contract_id'];
			$this->termination_date = $data['termination_date'];
		}
	}

}


?>