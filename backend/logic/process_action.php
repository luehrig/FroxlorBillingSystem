<?php

require '../../includes/classes/cl_customizing.php';
require '../../includes/classes/cl_content.php';

session_start();

include_once '../../configuration.inc.php';

require '../../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require '../../functions/general.php';

include_once '../../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';

$customizing = new customizing( get_default_language() );

$action = $_POST['action'];

switch($action) {

	case 'get_customizing_overview':
		echo '<div id="customizing_explanation"><p>'. EXPLANATION_CUSTOMIZING_ENTRIES .'</p></div>';
							
		echo $customizing->printCustomizingEntries();
		
		echo '<a href="#" id="modify_customizing">'. BUTTON_MODIFY_CUSTOMIZING_BACKEND .'</a>
			  <a href="#" id="save_customizing">'. BUTTON_SAVE_CUSTOMIZING_BACKEND .'</a>';
	break;
	
	case 'get_products_overview':
		$sql_products = 'SELECT p.title FROM '. TBL_PRODUCT .' AS p WHERE p.language_id = '. (int) get_default_language();
		$products_query = db_query($sql_products);
		
		$number_of_products = db_num_results($products_query);
		
		echo sprintf(EXPLANATION_NUMBER_OF_PRODUCTS, $number_of_products);
		
	break;
	
	case 'get_server_overview':
		echo 'Meine Server!';
		break;
	
	case 'get_customers_overview':
		echo 'Meine Kunden!';
	break;
	
	case 'get_content_overview':
		echo 'Mein Inhalt!';
		
		
		echo content::printOverview();
		
	break;
	
	case 'open_content_editor':
		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];
		
		$sql_statement = 'SELECT c.title, c.text FROM '. TBL_CONTENT .' AS c WHERE c.content_id = '. (int) $content_id .' AND c.language_id = '. (int) $language_id;
		$single_content_query = db_query($sql_statement);
		
		if(db_num_results($single_content_query) == 1) {
			
			$data = db_fetch_array($single_content_query);
			
			$echo_string = '<form><div id="edit_content_title"><input id="title" value="'. $data['title'] .'"/></div>';
			$echo_string = $echo_string .'<div id="edit_content_text"><textarea id="text" class="editor">'. $data['text'] .'</textarea></div>';
			
			$echo_string = $echo_string .'<div id="edit_content_buttons"><input type="submit" id="save_content" value="'. BUTTON_SAVE .'"></div></form>';
			
			echo $echo_string;
		}
		else {
			echo sprintf(ERROR_NO_CONTENT_ENTRY_FOUND, $content_id, $language_id);
		}
	
	break;
	
	case 'get_statistic_overview':
		echo 'Shopstatistiken!';
		break;

}	

?>