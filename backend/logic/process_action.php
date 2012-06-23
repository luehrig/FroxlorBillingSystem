<?php

require '../../includes/classes/cl_customizing.php';
require '../../includes/classes/cl_language.php';
require '../../includes/classes/cl_content.php';
require '../../includes/classes/cl_customer.php';
require '../../includes/classes/cl_country.php';
require '../../includes/classes/cl_product.php';
require '../../includes/classes/cl_server.php';
require '../../includes/classes/cl_product_attribute.php';
require '../../includes/classes/cl_product_info.php';

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

		$shown_language_id = language::getShownLanguageId();
		$id_language_map = language::getIdLanguageMap();
		echo product::printOverview($shown_language_id, $id_language_map);
		
	break;
	
	case 'open_product_editor':
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];	
		
		$product = new product($product_id, $language_id);
		$language_ids_for_existing_products = $product->getLanguagesForExistingProduct($product_id);
		$product_info = productInfo::getAttributesByProductId($product_id);
		$attributes_for_lang = productAttribute::getAllExistingAttrByLang($language_id);
		
		
		echo $product->printFormEdit($attributes_for_lang, $product_info, language::printLanguages($language_ids_for_existing_products, $language_id), $language_id);
		break;
		
		case 'open_create_new_attribute_for_product':
			$product_id = $_POST['product_id'];
			$language_id = $_POST['language_id'];
			$existing_attributes_for_lang = productAttribute::getAllExistingAttrByLang($language_id);
			$availible_attributes = productInfo::getAvailableAttributes($product_id, $existing_attributes_for_lang);
		
		
			echo productInfo::printNewAttributeForm($product_id, $availible_attributes);
			break;
		
		case 'create_new_product_info':
			$product_id = $_POST['product_id'];
			//$language_id = $_POST['language_id'];
			$attribute_id = $_POST['attribute_id'];
			$value = $_POST['value'];
		
		
			if(productInfo::create($product_id, $attribute_id, $value)){
				echo INFO_MESSAGE_PRODUCT_INFO_CREATION_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_DB_ACTION_FAILED;
			}
		
			break;
		
	case 'edit_product':
		
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$contract_periode = $_POST['contract_periode'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		
		$product_data = array("language_id"=>$language_id,
							  "title"=>$title,
							  "contract_periode"=>$contract_periode,
							  "description"=>$description,
							  "quantity"=>$quantity,
							  "price"=>$price);
		
		if(product::productExists($product_data, $product_id)){
			echo INFO_MESSAGE_PRODUCT_ALREADY_EXISTS;
		}
		else{
			$product = new product($product_id);
			if($product->update($product_id, $language_id, $product_data)){
				echo INFO_MESSAGE_PRODUCT_UPDATE_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_PRODUCT_UPDATE_FAILED;
			}
				
		}
		break;
		
		
	case 'open_translate_product_form':
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
	
		$product = new product($product_id, $language_id);
	
		echo $product->printFormTranslate(language::printLanguages());
	
		break;
		
	case 'translate_product':
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$contract_periode = $_POST['contract_periode'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		
		$product_data = array(
				"product_id"=>$product_id,
				"language_id"=>$language_id,
				"title"=>$title,
				"contract_periode"=>$contract_periode,
				"description"=>$description,
				"quantity"=>$quantity,
				"price"=>$price);
		
		if(product::translatedProductExists($product_data)){
			echo sprintf(INFO_MESSAGE_TRANSLATED_PRODUCT_ALREADY_EXISTS, $product_id);
		}
		else{
			$product = new product();
			if($product->saveTranslatedProduct($product_data)){
				echo sprintf(INFO_MESSAGE_TRANSLATION_SUCCEEDED, $product_id);
			}
			else{
				echo INFO_MESSAGE_PRODUCT_UPDATE_FAILED;
			}
		
		}
		break;
				
				
	case 'open_create_product_form':
		
		echo product::printCreateProductForm(language::printLanguages());
		
		break;

	case 'create_new_product':
		$product_id = null;
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$contract_periode = $_POST['contract_periode'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		
		$product_data = array("product_id" =>$product_id,
							  "language_id"=>$language_id, 
							  "title"=>$title,
							  "contract_periode"=>$contract_periode,
							  "description"=>$description,
							  "quantity"=>$quantity,
							  "price"=>$price);
		
		if(product::productExists($product_data, $product_id)){
			echo INFO_MESSAGE_PRODUCT_ALREADY_EXISTS;
		}
		else{ 
			if(product::create($product_data)){
				echo INFO_MESSAGE_PRODUCT_CREATION_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_DB_ACTION_FAILED;
			}	
		}
	
		break;
		
	case 'change_product_state':
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$product = new product($product_id, $language_id);
		$product_data = $product->getProductData();
		
		$current_state = $product_data['active'];
		$new_state;
		if($current_state == 1){
			$new_state = 0;
		}
		else {
			$new_state = 1;
		}
		
		$product_data['active'] = $new_state;
		if($product->changeProductState($product_data)){
			echo INFO_MESSAGE_PRODUCT_STATE_CHANGE_SUCCESSFUL;
		}
		else{
			echo INFO_MESSAGE_DB_ACTION_FAILED;
		}
		break;
		
		
	case 'delete_product':
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$product = new product($product_id, $language_id);
	
		if($product->delete($product_id, $language_id)){
			echo INFO_MESSAGE_PRODUCT_SUCCESSFULLY_DELETED;
		}
		else{
			echo INFO_MESSAGE_DB_ACTION_FAILED;
		}
			
		break;
		
		
		
		

	case 'get_product_attributes_overview':
		$shown_language_id = language::getShownLanguageId();
		$id_language_map = language::getIdLanguageMap();
		echo productattribute::printOverview($shown_language_id, $id_language_map);
				
			break;
			
		
	case 'open_product_attribute_editor':
		$product_attribute_id = $_POST['product_attribute_id'];
		$language_id = $_POST['language_id'];
		$product_attribute = new productAttribute($product_attribute_id, $language_id);
		$language_ids_for_existing_product_attributes = $product_attribute->getLanguagesForExistingProductAttr($product_attribute_id);
		
		echo $product_attribute->printFormEdit(language::printLanguages($language_ids_for_existing_product_attributes, $language_id), $language_id);
		
		break;
		
		
	case 'get_server_overview':

		echo server::printOverview();

		break;

	case 'open_create_server_form':

		echo server::printCreateServerForm();

		break;

	case 'create_new_server':
		$name = $_POST['name'];
		$mngmnt_ui = $_POST['mngmnt_ui'];
		$ipv4 = $_POST['ipv4'];
		$ipv6 = $_POST['ipv6'];
		$froxlor_username = $_POST['froxlor_username'];
		$froxlor_password = $_POST['froxlor_password'];
		$froxlor_db = $_POST['froxlor_db'];
		$froxlor_db_host = $_POST['froxlor_db_host'];
		$total_space = $_POST['total_space'];
		$free_space = $_POST['free_space'];
		$active = $_POST['active'];

		$server_data = array("name" =>$name,
				'mngmnt_ui'=>$mngmnt_ui,
				'ipv4'=>$ipv4,
				'ipv6'=>$ipv6,
				'froxlor_username'=>$froxlor_username,
				'froxlor_password'=>md5($froxlor_password),
				'froxlor_db'=>$froxlor_db,
				'froxlor_db_host'=>$froxlor_db_host,
				'total_space'=>$total_space,
				'free_space'=>$free_space,
				'active'=>$active);

		// check if ipv4 still exists in DB
		// TODO: in later release this is a candidate for customizing
		if(server::serverExists($server_data['ipv4'])){
			echo WARNING_MESSAGE_SERVER_ALREADY_EXISTS;
		}
		else{
			server::create($server_data);
		}

		break;



	case 'open_server_editor':
		$server_id = $_POST['server_id'];

		$server = new server($server_id);

		echo $server->printEditServerForm();

		break;

	case 'edit_server':

		$server_id = $_POST['server_id'];
		$name = $_POST['name'];
		$mngmnt_ui = $_POST['mngmnt_ui'];
		$ipv4 = $_POST['ipv4'];
		$ipv6 = $_POST['ipv6'];
		$froxlor_username = $_POST['froxlor_username'];
		$froxlor_password = md5($_POST['froxlor_password']);
		$froxlor_db = $_POST['froxlor_db'];
		$froxlor_db_host = $_POST['froxlor_db_host'];
		$total_space = $_POST['total_space'];
		$free_space = $_POST['free_space'];
		$active = $_POST['active'];

		$server_data = array("name" =>$name,
				'mngmnt_ui'=>$mngmnt_ui,
				'ipv4'=>$ipv4,
				'ipv6'=>$ipv6,
				'froxlor_username'=>$froxlor_username,
				'froxlor_password'=>md5($froxlor_password),
				'froxlor_db'=>$froxlor_db,
				'froxlor_db_host'=>$froxlor_db_host,
				'total_space'=>$total_space,
				'free_space'=>$free_space,
				'active'=>$active);

		$server = new server($server_id);
		$server->update($server_data);

		break;

	case 'delete_server':

		$server_id = $_POST['server_id'];
		
		$server = new server($server_id);
		$server->delete();

		break;


	case 'get_customers_overview':
		
		
		echo customer::printOverview();
		
		
	break;
	
	case 'open_customer_editor':
		$customer_id = $_POST['customer_id'];
		
		$customer = new customer($customer_id);
		
		echo $customer->printFormEdit();
		
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
		
		$content = new content($content_id, $language_id);
		$content->update($title, $text, $language_id);
		
	break;
	
	case 'create_content':
	
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$text = $_POST['text'];
	
		content::create($title, $text, $language_id);
	
		break;
	
	case 'delete_content':

		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];
		
		$content = new content($content_id, $language_id);
		$content->delete($language_id);
		
		break;
		
	case 'get_statistic_overview':
		echo 'Shopstatistiken!';
		break;	
		
}	

?>
