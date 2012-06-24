<?php

function getTimestamp() {
	return date('Y-m-d H:i:s');
}

// transform mysql date into german format
function mysql_date2german($date) {
	$parts = explode("-",$date);
	return sprintf("%02d.%02d.%04d", $parts[2], $parts[1], $parts[0]);
}

?>