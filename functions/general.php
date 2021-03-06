<?php

// require PATH_FUNCTIONS .'database.php';
// db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// include_once PATH_INCLUDES .'database_tables.php';

// get default language from customizing
function get_default_language() {
	$sql_statement = 'SELECT cust.value AS default_language FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "default_language"';
	$query = db_query($sql_statement);
	$default_language = db_fetch_array($query);
	
	return $default_language['default_language'];
}

// read site title from customizing
function get_site_title($language_id = NULL) {
	// if no language is set -> use default language from customizing
	if(language_id == NULL) {
		$default_language = get_default_language();
		
		$sql_statement = 'SELECT cust.value AS site_title FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "site_title" AND cust.language_id = '. $default_language['default_language'];
	}
	// query site title with given language
	else {
		$sql_statement = 'SELECT cust.value AS site_title FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "site_title" AND cust.language_id = '. $language_id;
	}
	
	$db_query = db_query($sql_statement);
	$result_array = db_query_with_result($db_query);
	
	return $result_array['site_title'];
}

// get setup date of installation
function get_setup_date() {
	$sql_statement = 'SELECT cust.value as setup_date FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "setup_date"';
	$db_query = db_query($sql_statement);
	$result_array = db_query_with_result($db_query);
	
	return $result_array['setup_date'];
}

// get minimum password length from customizing
function get_min_password_length() {
	$sql_statement = 'SELECT cust.value as min_password_length FROM '. TBL_CUSTOMIZING .' AS cust WHERE cust.key = "min_password_length"';
	$db_query = db_query($sql_statement);
	$result_array = db_query_with_result($db_query);
	
	return $result_array['min_password_length'];
}

// search array with key
function search($searchKey, $array){
	foreach($array as $key => $value){
		if($key == $searchKey){
			return array($key);
		}
		elseif(is_array($value)){
			$retVal = search($value, $searchKey);
			if(is_array($retVal)){
				$retVal[] = $key;
				return $retVal;
			}
		}
	}
	return false;
}

// registration check if entered emaill address already exists
function checkIfEmailAlreadyExists($email){
	$sql_select_statement = 'SELECT c.email  FROM '. TBL_CUSTOMER .' as c WHERE c.email = "'. $email .'"';
	$db_result_array = db_fetch_array(db_query($sql_select_statement));
	if ($db_result_array != NULL){
		return true;
	}
	else {
		return false;
	}
}

?>