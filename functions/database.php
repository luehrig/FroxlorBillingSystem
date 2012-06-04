<?php

// set up a database connection to server
function db_connect($db_server, $db_user, $db_password, $db_name, $connection = 'db_connection') {
	global $$connection;
	
	$$connection = mysql_connect($db_server,$db_user,$db_password) OR die(mysql_error());
	
	if($$connection) {
		mysql_set_charset('utf8',$$connection);
		mysql_select_db($db_name);
	}
	
	return $$connection;
}


// do query on database
function db_query($sql_statement,$connection = 'db_connection') {
	global $$connection;
	
	$result = mysql_query($sql_statement, $$connection) or db_error($sql_statement, mysql_errno(), mysql_error());
	
	return $result;
}

// get number of query results
function db_num_results($db_query) {
	return mysql_num_rows($db_query);
}

// get result as array
function db_fetch_array($db_query) {
	return mysql_fetch_array($db_query, MYSQL_ASSOC);
}

function db_error($db_query, $errno, $error) {
	die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $db_query . '<br><br><small><font color="#ff0000">[DB STOP]</font></small><br><br></b></font>');
}

function db_close($connection = 'db_connection') {
	global $$connection;

	return mysql_close($$connection);
}

function db_insert_id($connection = 'db_connection') {
	global $$connection;
	
	return mysql_insert_id($$connection);
}

?>