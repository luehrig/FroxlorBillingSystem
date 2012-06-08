<?php

require '../../includes/classes/cl_customizing.php';
require '../../includes/classes/cl_language.php';
require '../../includes/classes/cl_content.php';
require '../../includes/classes/cl_customer.php';
require '../../includes/classes/cl_country.php';

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
		
		echo '<a href="#" id="edit_customizing">'. BUTTON_MODIFY_CUSTOMIZING_BACKEND .'</a>
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
		
		
		echo customer::printOverview();
		
		
	break;
	
	case 'open_customer_editor':
		$customer_id = $_POST['customer_id'];
		
		$customer = new customer($customer_id);
		
		echo $customer->printForm();
		
	break;
	
	case 'get_content_overview':
		echo 'Mein Inhalt!';
		
		
		echo content::printOverview();
		
		echo '<div id="new_content_buttons"><a href="#" id="create_new_content">'. BUTTON_CREATE_CONTENT .'</a></div>';
		
	break;
	
	case 'open_new_content_editor':
		
		$echo_string = '<form><div id="new_content_title"><input type="text" id="title" /></div>';
		$echo_string = $echo_string .'<div id="new_content_text"><textarea id="text" class="editor"></textarea></div>';
			
		$echo_string = $echo_string . language::printLanguages();
		
		$echo_string = $echo_string .'<div id="new_content_buttons"><input type="submit" id="create_content" value="'. BUTTON_SAVE .'"></div></form>';
			
		echo $echo_string;
		
	break;	
	
	case 'open_content_editor':
		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];
		
		$sql_statement = 'SELECT c.title, c.text FROM '. TBL_CONTENT .' AS c WHERE c.content_id = '. (int) $content_id .' AND c.language_id = '. (int) $language_id;
		$single_content_query = db_query($sql_statement);
		
		if(db_num_results($single_content_query) == 1) {
			
			$data = db_fetch_array($single_content_query);
			
			$echo_string = '<form><div id="edit_content_title"><input type="text" id="title" value="'. $data['title'] .'"/></div>';
			$echo_string = $echo_string .'<div id="edit_content_text"><textarea id="text" class="editor">'. $data['text'] .'</textarea></div>';
			
			$echo_string = $echo_string .'<div id="edit_content_buttons"><input type="submit" id="save_content" value="'. BUTTON_SAVE .'"></div></form>';
			
			$echo_string = $echo_string .'<input type="hidden" id="content_id" value="'. $content_id .'">';
			$echo_string = $echo_string .'<input type="hidden" id="language_id" value="'. $language_id .'">';
			
			echo $echo_string;
		}
		else {
			echo sprintf(ERROR_NO_CONTENT_ENTRY_FOUND, $content_id, $language_id);
		}
	
	break;
	
	case 'update_content':
		
		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$text = $_POST['text'];
		
		$content = new content($content_id);
		$content->update($title, $text, $language_id);
		
	break;
	
	case 'create_content':
	
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$text = $_POST['text'];
	
		content::create($title, $text, $language_id);
	
		break;
	
	case 'get_statistic_overview':
		echo 'Shopstatistiken!';
		break;

}	

?>