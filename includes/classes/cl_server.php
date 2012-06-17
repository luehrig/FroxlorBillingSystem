<?php

class server {
	
	private $server_id;
	private $name;
	private $mngmnt_ui;
	private $ipv4;
	private $ipv6;
	private $free_space;
	private $froxlor_credentials;

	
	/* constructor */
	public function __construct($server_id) {
		$this->load($server_id);
		
	}
	
	
	/* public section */
	// create new server
	public static function create($server_data) {
		
		
		
	}
	
	// update server
	public function update($server_data) {
		
	}
	
	// delete server that exists
	public function delete() {
		$delete_statement = 'DELETE FROM '. TBL_SERVER .' WHERE server_id = '. (int) $this->server_id;
		db_query($delete_statement);
	}
	
	
	/* private section */
	private function load($server_id) {
		$sql_statement = 'SELECT name, mngmnt_ui, ipv4, ipv6, froxlor_username, froxlor_password, froxlor_db, froxlor_db_host, free_space FROM '. TBL_SERVER .' WHERE server_id = '. (int) $server_id;
		$query = db_query($sql_statement);
		
		if(db_num_results($query) == 1) {
			$data = db_fetch_array($query);
			
			// set master data in object
			$this->server_id = $server_id;
			$this->name = $data['name'];
			$this->mngmnt_ui = $data['mngmnt_ui'];
			$this->ipv4 = $data['ipv4'];
			$this->ipv6 = $data['ipv6'];
			$this->free_space = $data['free_space'];
			
			// set froxlor credentials in object
			$this->froxlor_credentials[] = array(
					'db_server' => $data['froxlor_db_host'],
					'db_name' => $data['froxlor_db'],
					'user' => $data['froxlor_username'],
					'password' => $data['froxlor_password']);
			
		}
		// server was not found return null object to caller
		else {
			return null;
		}
	}
	
	
}


?>