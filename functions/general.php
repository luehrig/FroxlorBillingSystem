<?php

// get default language from customizing
function get_default_language() {
	$sql_statement = 'SELECT value AS default_language FROM '. TBL_CUSTOMIZING .' WHERE key = default_language';
	$default_language = db_query_with_result($sql_statement);
	$db_query = db_query($sql_statement);
	$result_array = db_fetch_result($db_query);
	
	return $result_array['default_language'];
}

// read site title from customizing
function get_site_title($language_id = '') {
	// if no language is set -> use default language from customizing
	if(language_id == '') {
		$default_language = get_default_language();
		
		$sql_statement = 'SELECT value AS site_title FROM '. TBL_CUSTOMIZING .' WHERE key = site_title AND language_id = '. $default_language['default_language'];
	}
	// query site title with given language
	else {
		$sql_statement = 'SELECT value AS site_title FROM '. TBL_CUSTOMIZING .' WHERE key = site_title AND language_id = '. $language_id;
	}
	
	$db_query = db_query($sql_statement);
	$result_array = db_fetch_result($db_query);
	
	return $result_array['site_title'];
}

// get setup date of installation
function get_setup_date() {
	$sql_statement = 'SELECT value as setup_date FROM '. TBL_CUSTOMIZING .' WHERE key = setup_date';
	$db_query = db_query($sql_statement);
	$result_array = db_fetch_result($db_query);
	
	return $result_array['setup_date'];
}



?>