<?php

class server {

	private $server_id;
	private $name;
	private $mngmnt_ui;
	private $ipv4;
	private $ipv6;
	private $total_space;
	private $free_space;
	private $active;
	private $froxlor_credentials;


	/* constructor */
	public function __construct($server_id) {
		$this->load($server_id);
	}


	/* public section */
	// create new server
	public static function create($server_data) {

		if($server_data != NULL) {
			$sql_statement = 'INSERT INTO '. TBL_SERVER .' (name, mngmnt_ui, ipv4, ipv6, froxlor_username, froxlor_password, froxlor_db, froxlor_db_host, total_space, free_space, active)
			VALUES (
			"'. $server_data['name'] .'",
			"'. $server_data['mngmnt_ui'] .'",
			"'. $server_data['ipv4'] .'",
			"'. $server_data['ipv6'] .'",
			"'. $server_data['froxlor_username'] .'",
			"'. $server_data['froxlor_password'] .'",
			"'. $server_data['froxlor_db'] .'",
			"'. $server_data['froxlor_db_host'] .'",
			"'. $server_data['total_space'] .'",
			"'. $server_data['free_space'] .'",
			'. (int) $server_data['active'] .')';
			$result = db_query($sql_statement);
				
			// if insertion was successful return server object
			if($result != false ) {
				return new server(db_insert_id());
			}
			else {
				return null;
			}
		}
	}

	// update server
	public function update($server_data) {
		if($server_data != NULL){
			$sql_statement = 'UPDATE '. TBL_SERVER .' SET
			name = "'. $server_data['name'] .'",
			mngmnt_ui = "'. $server_data['mngmnt_ui'] .'",
			ipv4 = "'. $server_data['ipv4'] .'",
			ipv6 = "'. $server_data['ipv6'] .'",
			froxlor_username = "'. $server_data['froxlor_username'] .'",
			froxlor_db = "'. $server_data['froxlor_db'] .'",
			froxlor_db_host = "'. $server_data['froxlor_db_host'] .'",
			total_space = "'. $server_data['total_space'] .'",
			free_space = "'. $server_data['free_space'] .'",
			active = '. (int) $server_data['active'] .' 
			WHERE server_id = '. (int) $this->server_id .'';

			$result = db_query($sql_statement);
				
			// update password only if set
			if($server_data['froxlor_password'] != '') {
				$sql_statement = 'UPDATE '. TBL_SERVER .' SET
				froxlor_password = "'. $server_data['froxlor_password'] .'"
				WHERE server_id = "'. $this->server_id .'"';

				$result = db_query($sql_statement);
			}
				
			// load new data
			$this->load($this->server_id);
		}
	}

	// delete server that exists
	public function delete() {
		$delete_statement = 'DELETE FROM '. TBL_SERVER .' WHERE server_id = '. (int) $this->server_id;
		return db_query($delete_statement);
	}

	
	// book product on server
	public function bookProduct($product_id) {
		// get required disc space for product
		$sql_statement = 'SELECT pi.value FROM '. TBL_PRODUCT_INFO .' AS pi WHERE pi.product_id = '. (int) $product_id;
		$required_discspace_query = db_query($sql_statement);
		
		// if discspace is available for product update server
		if(db_num_results($required_discspace_query) == 1) {
			$required_discspace = db_fetch_array($required_discspace_query);
			
			$sql_statement = 'UPDATE '. TBL_SERVER .' SET free_space = free_space - '. (int) $required_discspace .' WHERE server_id = '. (int) $this->server_id;
			return db_query($sql_statement);
		}
		else {
			return WARNING_SERVER_NOT_ABLE_TO_ALLOCATE;
		}		
		
	}
	
	// terminate product
	public function terminateProduct($product_id) {
		// get required disc space for product
		$sql_statement = 'SELECT pi.value FROM '. TBL_PRODUCT_INFO .' AS pi WHERE pi.product_id = '. (int) $product_id;
		$required_discspace_query = db_query($sql_statement);
		
		// if discspace is available for product update server
		if(db_num_results($required_discspace_query) == 1) {
			$required_discspace = db_fetch_array($required_discspace_query);
				
			$sql_statement = 'UPDATE '. TBL_SERVER .' SET free_space = free_space + '. (int) $required_discspace .' WHERE server_id = '. (int) $this->server_id;
			return db_query($sql_statement);
		}
		else {
			return WARNING_SERVER_NOT_ABLE_TO_FREE;
		}
	}
	
	// return server that fits best for product
	public static function getAppropriateServer($product_id,$quantity = 1) {
		$customizing = new customizing();
		$diskspace_attribute_id = $customizing->getCustomizingValue('sys_product_attribute_discspace');
		
		$sql_statement = 'SELECT s.server_id FROM '. TBL_SERVER .' AS s, '. TBL_PRODUCT .' AS p INNER JOIN '. TBL_PRODUCT_INFO .' AS pi ON p.product_id = pi.product_id WHERE p.product_id = '. (int) $product_id .' AND pi.attribute_id = '. (int) $diskspace_attribute_id .' AND s.free_space > pi.value * '. (int) $quantity .' LIMIT 0,1';
		$query = db_query($sql_statement);

		// check if appropriated server exists
		if(db_num_results($query) == 1) {
			$result_data = db_fetch_array($query);
			return $result_data['server_id'];
		}
		else {
			return NULL;
		}
	}
	
	// return table with all servers
	public static function printOverview($container_id = 'server_overview'){
		$sql_statement = 'SELECT s.server_id, s.name, s.free_space, s.total_space, s.active FROM '. TBL_SERVER .' AS s ORDER BY s.name ASC, s.free_space DESC';
		$server_query = db_query($sql_statement);
		$number_of_servers = db_num_results($server_query);

		$return_string = '<div id="'. $container_id .'">';
		$return_string = $return_string . sprintf(EXPLANATION_NUMBER_OF_SERVERS, $number_of_servers);


		$create_button = '<a href="#" id="create_new_server" class="button_style">'.BUTTON_CREATE_SERVER.'</a></td>';


		$return_string = $return_string;


		$table_header = '<table border = "0">
		<tr>
		<th>'. TABLE_HEADING_SERVER_NAME .'</th>
		<th>'. TABLE_HEADING_SERVER_DISK_SPACE .'</th>
		<th>'. TABLE_HEADING_SERVER_STATUS.'</th>
		<th></th><th></th>
		</tr>';

		$table_content = '';
		while($data = db_fetch_array($server_query)) {
			$table_content = $table_content .'<tr>
			<td>'. $data['name'] .'</td>
			<td>'. $data['free_space'] .' / '. $data['total_space'] .'</td>
			<td>';
			
			// TODO: icons please
			if($data['active'] == 1) {
				$table_content = $table_content . '<img src="'. PATH_IMAGES_REL .'activate.png" title="'. LABEL_ACTIVE .'">';
			}
			else {
				$table_content = $table_content . '<img src="'. PATH_IMAGES_REL .'deactivate.png" title="'. LABEL_INACTIVE .'">';
			}
			
			$table_content = $table_content .'</td>
			<td><a href="#" id="edit_server" rel="'. $data['server_id'] .'"><img src="'. PATH_IMAGES_REL .'edit.png" title="'. LINK_EDIT_PRODUCT .'"></a></td>
			<td><a href="#" id="delete_server" rel="'. $data['server_id'] .'"><img src="'. PATH_IMAGES_REL .'delete.png" title="'. LINK_DELETE . '"></a></td>
			</tr>';
		}
		$return_string = $return_string . $table_header . $table_content. '</table><br>' . $create_button;
		return $return_string;
	}

	// form to create a new server in backend
	public static function printCreateServerForm($container_id = 'new_server_editor') {

		$return_string = '<div id="'. $container_id .'">.
		<form method="post">'.'<fieldset>'.
		'<legend>'. FIELDSET_SERVER_SERVER_DATA .'</legend>'.
		'<label for="name">'. LABEL_SERVER_NAME .'</label>'.
		'<input type="text" id="name" name="name"><br>'.
		'<label for="mngmnt_ui">'. LABEL_SERVER_MNGMNT_UI .'</label>'.
		'<input type="text" id="mngmnt_ui" name="mngmnt_ui"><br>'.
		'<label for="ipv4">'. LABEL_SERVER_IPV4 .'</label>'.
		'<input type="text" id="ipv4" name="ipv4" ><br>'.
		'<label for="ipv6">'. LABEL_SERVER_IPV6 .'</label>'.
		'<input type="text" id="ipv6" name="ipv6"><br>'.
		'<label for="total_space">'. LABEL_SERVER_TOTAL_SPACE .'</label>'.
		'<input type="text" id="total_space" name="total_space"><br>'.
		'<label for="free_space">'. LABEL_SERVER_FREE_SPACE .'</label>'.
		'<input type="text" id="free_space" name="free_space"><br>'.
		'<label for="active">'. LABEL_SERVER_AVAILABLE .'</label>'.
		'<input type="checkbox" id="active" name="active" value="1">'.
		'</fieldset>'.
		'<fieldset>'.'<legend>'. FIELDSET_SERVER_FROXLOR_DATA .'</legend>'.
		'<label for="froxlor_username">'. LABEL_SERVER_FROXLOR_USERNAME .'</label>'.
		'<input type="text" id="froxlor_username" name="froxlor_username"><br>'.
		'<label for="froxlor_password">'. LABEL_SERVER_FROXLOR_PASSWORD .'</label>'.
		'<input type="password" id="froxlor_password" name="froxlor_password"><br>'.
		'<label for="froxlor_db_host">'. LABEL_SERVER_FROXLOR_DB_HOST .'</label>'.
		'<input type="text" id="froxlor_db_host" name="froxlor_db_host"><br>'.
		'<label for="froxlor_db">'. LABEL_SERVER_FROXLOR_DB .'</label>'.
		'<input type="text" id="froxlor_db" name="froxlor_db"><br>'.
		'</fieldset>';

		$return_string = $return_string . '<input type="submit" name="create_server" id="create_server" value="'. BUTTON_CREATE_SERVER .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;

	}
	
	// form to edit a server in backend
	public function printEditServerForm($container_id = 'edit_server_editor') {
		'<div class="editserverlayout>"';
		$return_string = '<div id="'. $container_id .'">
		<form method="post">'.'<fieldset>'.
		'<legend>'. FIELDSET_SERVER_SERVER_DATA .'</legend>'.
		'<p><label for="name">'. LABEL_SERVER_NAME .'</label><div class="space"></div>'.
		'<input type="text" id="name" name="name" value="'. $this->name .'"></p><br>'.
		'<p><label for="mngmnt_ui">'. LABEL_SERVER_MNGMNT_UI .'</label><div class="space"></div>'.
		'<input type="text" id="mngmnt_ui" name="mngmnt_ui" value="'. $this->mngmnt_ui .'"></p><br>'.
		'<p><label for="ipv4">'. LABEL_SERVER_IPV4 .'</label><div class="space"></div>'.
		'<input type="text" id="ipv4" name="ipv4" value="'. $this->ipv4 .'"></p><br>'.
		'<p><label for="ipv6">'. LABEL_SERVER_IPV6 .'</label><div class="space"></div>'.
		'<input type="text" id="ipv6" name="ipv6" value="'. $this->ipv6 .'"></p><br>'.
		'<p><label for="total_space">'. LABEL_SERVER_TOTAL_SPACE .'</label><div class="space"></div>'.
		'<input type="text" id="total_space" name="total_space"  value="'. $this->total_space .'"></p><br>'.
		'<p><label for="free_space">'. LABEL_SERVER_FREE_SPACE .'</label><div class="space"></div>'.
		'<input type="text" id="free_space" name="free_space" value="'. $this->free_space .'"></p><br>'.
		'<p><label for="active">'. LABEL_SERVER_AVAILABLE .'</label><div class="space"></div>';
		
		if($this->active == 1) {
			$return_string = $return_string .'<input type="checkbox" id="active" name="active"  value="'. $this->active .'" checked></p><br>';
		}
		else {
			$return_string = $return_string .'<input type="checkbox" id="active" name="active"  value="'. $this->active .'"></p><br>';
		}
		
		$return_string = $return_string .'</fieldset>'.
		'<fieldset>'.'<legend>'. FIELDSET_SERVER_FROXLOR_DATA .'</legend>'.
		'<p><label for="froxlor_username">'. LABEL_SERVER_FROXLOR_USERNAME .'</label><div class="space"></div>'.
		'<input type="text" id="froxlor_username" name="froxlor_username" value="'. $this->froxlor_credentials['user'] .'"></p><br>'.
		'<p><label for="froxlor_password">'. LABEL_SERVER_FROXLOR_PASSWORD .'</label><div class="space"></div>'.
		'<input type="password" id="froxlor_password" name="froxlor_password"></p><br>'.
		'<p><label for="froxlor_db_host">'. LABEL_SERVER_FROXLOR_DB_HOST .'</label><div class="space"></div>'.
		'<input type="text" id="froxlor_db_host" name="froxlor_db_host"  value="'. $this->froxlor_credentials['db_server'] .'"></p><br>'.
		'<p><label for="froxlor_db">'. LABEL_SERVER_FROXLOR_DB .'</label><div class="space"></div>'.
		'<input type="text" id="froxlor_db" name="froxlor_db"  value="'. $this->froxlor_credentials['db_name'] .'"></p><br>'.
		'</fieldset>';
	
		$return_string = $return_string . '<input type="hidden" name="server_id" id="server_id" value="'. $this->server_id .'">';
		$return_string = $return_string . '<input type="submit" name="edit_server" id="edit_server" value="'. BUTTON_CHANGE_SERVER .'">';
		$return_string = $return_string . '</form></div>';
		return $return_string;
		'</div>';
	}

	// return true if a server still exists with same ip
	public static function serverExists($ipv4 = NULL, $ipv6 = NULL) {
		// check is performed with ipv4
		if($ipv6 == NULL) {
			$sql_statement = 'SELECT s.server_id FROM '. TBL_SERVER .' AS s WHERE s.ipv4 = "'. $ipv4 .'"';
		}
		// check is performed with ipv6
		else if($ipv4 == NULL) {
			$sql_statement = 'SELECT s.server_id FROM '. TBL_SERVER .' AS s WHERE s.ipv6 = "'. $ipv6 .'"';
		}
		// check is performed with ipv4 AND ipv6
		else {
			$sql_statement = 'SELECT s.server_id FROM '. TBL_SERVER .' AS s WHERE s.ipv4 = "'. $ipv4 .'" AND s.ipv6 = "'. $ipv6 .'"';
		}

		$query = db_query($sql_statement);

		// no server with ip exists
		if(db_num_results($query) == 0) {
			return false;
		}
		// server still exists
		else {
			return true;
		}
	}

	/* private section */
	private function load($server_id) {
		$sql_statement = 'SELECT s.name, s.mngmnt_ui, s.ipv4, s.ipv6, s.froxlor_username, s.froxlor_password, s.froxlor_db, s.froxlor_db_host, s.total_space, s.free_space, s.active FROM '. TBL_SERVER .' AS s WHERE s.server_id = '. (int) $server_id;
		$query = db_query($sql_statement);

		if(db_num_results($query) == 1) {
			$data = db_fetch_array($query);

			// set master data in object
			$this->server_id = $server_id;
			$this->name = $data['name'];
			$this->mngmnt_ui = $data['mngmnt_ui'];
			$this->ipv4 = $data['ipv4'];
			$this->ipv6 = $data['ipv6'];
			$this->total_space = $data['total_space'];
			$this->free_space = $data['free_space'];
			$this->active = $data['active'];

			// set froxlor credentials in object
			$this->froxlor_credentials = array(
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