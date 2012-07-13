<?php

// escapes whole array to prevent sql injection attacks
function db_security_escape_string_array($array) {
	foreach($array AS $key => $value) {
		$array[$key] = mysql_real_escape_string($array[$key]);
	}

	return $array;	
}


?>