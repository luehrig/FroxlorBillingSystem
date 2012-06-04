<?php

// set up a database connection to server
function db_connect($db_server, $db_user, $db_password, $db_name) {
	$connection = mysql_connect($db_server,$db_user,$db_password) OR die(mysql_error());
	mysql_select_db($db_name, $connection) or die(mysql_error());
	return $connection;
}


// do query on database
function db_query($sql_statement,$db_connection = '') {
	// transform evil chars
	$sec_sql_statement = mysql_real_escape_string($sql_statement);
	
	// if no db connection was handed over use default
	if($db_connection == '') {
		return mysql_query($sec_sql_statement);
	}
	else {
		return mysql_query($sec_sql_statement, $db_connection);
	}
}

// transform db query into array format
function db_fetch_result($db_query_result) {
	return mysql_fetch_assoc($db_query_result);
}

// get number of query results
function db_num_results($db_query_result) {
	return mysql_num_rows($db_query_result);
}

// do db query and return an array with result set
function db_query_with_result($sql_statement) {
	$query_result = db_query($sql_statement);
	return db_fetch_result($query_result);
}


?>