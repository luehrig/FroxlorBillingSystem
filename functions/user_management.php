<?php

// check if user credentials match with one entry in user database
function db_user_check_credentials ( $username, $password ) {
	$credentials_ok = false;

	// try first combination of username as email and password
	$sql_statement = 'SELECT customer_id, first_name, last_name FROM '. TBL_CUSTOMER .' WHERE email = "'. $username .'" AND password = "' . sha1($password) .'"';
	$credential_check_query = db_query($sql_statement);
	
	// check if first check returns a result. If this is not the case try to use the username as customer number
	if(db_num_results($credential_check_query) == 0) {
		
		$sql_statement = 'SELECT customer_id, first_name, last_name FROM '. TBL_CUSTOMER .' WHERE customer_number = "'. $username .'" AND password = "' . sha1($password) .'"';
		$credential_check_query = db_query($sql_statement);
		
		// if second try is successfully set indicator to true
		if(db_num_results($credential_check_query) == 1) {
			$credentials_ok = true;
		}
		
	}
	else {
		$credentials_ok = true;
	}
	
	// if credential indicator was set to true, return array with some information about user
	// if no credentials for user was found, return false
	if($credentials_ok == true) {
		return db_fetch_array($credential_check_query);
	}
	else {
		return false;
	}
}

// check if user credentials match with one entry in backend user database
function db_backend_user_check_credentials ( $username, $password ) {
	$credentials_ok = false;

	// try first combination of username as email and password
	$sql_statement = 'SELECT backend_user_id, first_name, last_name FROM '. TBL_BACKEND_USER .' WHERE email = "'. $username .'" AND password = "' . sha1($password) .'"';
	$credential_check_query = db_query($sql_statement);

	// check if check has a result which means that user exists
	if(db_num_results($credential_check_query) == 1) {
		$credentials_ok = true;
	}

	// if credential indicator was set to true, return array with some information about user
	// if no credentials for user was found, return false
	if($credentials_ok == true) {
		return db_fetch_array($credential_check_query);
	}
	else {
		return false;
	}
}

// write customer to active session table
function db_customer_login ( $customer_id, $session_id ) {
	// delete old sessions
	$sql_statement = 'DELETE FROM '. TBL_ACTIVE_CUSTOMER .' WHERE customer_id = '. (int) $customer_id;
	db_query($sql_statement);
	
	$sql_statement = 'INSERT INTO '. TBL_ACTIVE_CUSTOMER .' (customer_id, session_id, start_date, expiration_date) VALUES ('. (int) $customer_id .', "'. $session_id .'", NOW() ,  DATE_ADD(NOW(), INTERVAL 30 MINUTE))';
	$customer_login_query = db_query($sql_statement);
	
	// check if any errors occured while insert customer ID to session table
	if ( $customer_login_query == false ) {
		exit(mysql_error());
	}
}

// write backend user to active session table
function db_backend_login ( $backend_user_id, $session_id ) {
	// delete old sessions
	$sql_statement = 'DELETE FROM '. TBL_ACTIVE_BACKEND_USER .' WHERE backend_user_id = '. (int) $backend_user_id;
	db_query($sql_statement);
	
	$sql_statement = 'INSERT INTO '. TBL_ACTIVE_BACKEND_USER .' (backend_user_id, session_id, start_date, expiration_date) VALUES ('. (int) $backend_user_id .', "'. $session_id .'", NOW() ,  DATE_ADD(NOW(), INTERVAL 30 MINUTE))';
	$backend_login_query = db_query($sql_statement);

	// check if any errors occured while insert backend user ID to session table
	if ( $backend_login_query == false ) {
		exit(mysql_error());
	}
}

// check if user is logged in and has a valid session that is not expired
function db_user_is_logged_in($session_id) {
	$sql_statement = 'SELECT customer_id FROM '. TBL_ACTIVE_CUSTOMER .' WHERE session_id = '. (int) $session_id .' AND expiration_date > NOW()';
	$check_login_query = db_query($sql_statement);
	
	// check if any errors occured while session check
	if ( $check_login_query == false ) {
		exit(mysql_error());
	}
	
	// a valid session was found
	// update expiration_date and return true
	if ( db_num_results($check_login_query) == 1) {
		$sql_statement = 'UPDATE '. TBL_ACTIVE_CUSTOMER .' SET expiration_date = DATE_ADD(NOW(), INTERVAL 30 MINUTE)';
		db_query($sql_statement);
		
		return true;
	}
	else {
		return false;
	}
}

// check if backend user is logged in and has a valid session that is not expired
function db_backend_user_is_logged_in($session_id) {
	$sql_statement = 'SELECT backend_user_id FROM '. TBL_ACTIVE_BACKEND_USER .' WHERE session_id = '. (int) $session_id .' AND expiration_date > NOW()';
	$check_login_query = db_query($sql_statement);

	// check if any errors occured while session check
	if ( $check_login_query == false ) {
		exit(mysql_error());
	}

	// a valid session was found
	// update expiration_date and return true
	if ( db_num_results($check_login_query) == 1) {
		$sql_statement = 'UPDATE '. TBL_ACTIVE_BACKEND_USER .' SET expiration_date = DATE_ADD(NOW(), INTERVAL 30 MINUTE)';
		db_query($sql_statement);

		return true;
	}
	else {
		return false;
	}
}


// delete given session id from active session table
function db_user_customer_logout($session_id) {
	$sql_statement = 'DELETE FROM '. TBL_ACTIVE_CUSTOMER .' WHERE session_id = "'. $session_id .'"';
	$delete_session_query = db_query($sql_statement);
	
	if ( $delete_session_query == false ) {
		exit(mysql_error());
	}
}

// delete given session id from active session table (backend)
function db_user_backend_logout($session_id) {
	$sql_statement = 'DELETE FROM '. TBL_ACTIVE_BACKEND_USER .' WHERE session_id = "'. $session_id .'"';
	$delete_session_query = db_query($sql_statement);

	if ( $delete_session_query == false ) {
		exit(mysql_error());
	}
}

?>