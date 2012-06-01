<?php

// read site title from customizing
function get_site_title() {
	$sql_statement = 'SELECT value AS site_title FROM '. TBL_CUSTOMIZING .' WHERE key = site_title';
	$db_query = db_query($sql_statement);
	$result_array = db_fetch_result($db_query);
	
	return $result_array['site_title'];
}


?>