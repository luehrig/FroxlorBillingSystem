<?php

// set up a database connection to server
function db_connect($db_server, $db_user, $db_password) {
	return mysql_connect($db_server,$db_user,$db_password) OR die(mysql_error());;
}


// do query on database
function db_query($sql_statement,$db_connection = '') {
	// transform evil chars
	$sec_sql_statement = mysql_real_escape_string($sql_statement);
	
	// if no db connection was handed over use default
	if($db_connection == '') {
		mysql_query($sec_sql_statement);
	}
	else {
		mysql_query($sec_sql_statement, $db_connection);
	}
}
?>