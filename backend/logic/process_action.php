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
require '../../includes/classes/cl_invoice.php';
require '../../includes/classes/cl_order.php';
require '../../includes/classes/cl_currency.php';
require_once '../../includes/classes/cl_contract.php';

session_start();

include_once '../../configuration.inc.php';

require '../../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require '../../functions/general.php';
require_once  '../../functions/datetime.php';

include_once '../../includes/database_tables.php';
// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();

include_once '../../includes/languages/'. strtoupper($site_language) .'.inc.php';

$customizing = new customizing( get_default_language() );

$action = $_POST['action'];

echo '<div class=internalwrapper>';
switch($action) {

	case 'get_customizing_overview':
		echo'<h1>'.LABEL_MY_SHOP.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo '<div id="customizing_explanation"><p>'. EXPLANATION_CUSTOMIZING_ENTRIES .'</p></div>';
		echo $customizing->printCustomizingEntries();
		
		echo '<div class="space">';
		
		echo '<a href="#" id="edit_customizing" class="button_style">'. BUTTON_MODIFY_CUSTOMIZING_BACKEND .'</a>
		<a href="#" id="save_customizing"  class="button_style">'. BUTTON_SAVE_CUSTOMIZING_BACKEND .'</a>';
		
		echo '</div></fieldset>';
		echo '</div>';
		break;

	case 'get_products_overview':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$shown_language_id = language::getShownLanguageId();
		$id_language_map = language::getIdLanguageMap();
		echo product::printOverview($shown_language_id, $id_language_map);


		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_product_editor':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];

		$product = new product($product_id, $language_id);
		$language_ids_for_existing_products = $product->getLanguagesForExistingProduct();
		$product_info = productInfo::getAttributesByProductId($product_id);
		$attributes_for_lang = productAttribute::getAllExistingAttrByLang($language_id);


		echo $product->printFormEdit($attributes_for_lang, $product_info, language::printLanguages($language_ids_for_existing_products, $language_id), $language_id);
		
		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_create_new_attribute_for_product':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$existing_attributes_for_lang = productAttribute::getAllExistingAttrByLang($language_id);
		$availible_attributes = productInfo::getAvailableAttributes($product_id, $existing_attributes_for_lang);

		echo productInfo::printNewAttributeForm($product_id, $availible_attributes);
		echo '</fieldset>';
		echo '</div>';
		break;

	case 'create_new_product_info':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
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

		echo '</fieldset>';
		echo '</div>';
		break;
		
	case 'delete_product_info':
		$product_id = $_POST['product_id'];
		$attribute_id = $_POST['attribute_id'];
		
		$product_info = new productInfo($product_id, $attribute_id);
		
		if($product_info->delete()){
			echo INFO_MESSAGE_PRODUCT_INFO_SUCCESSFULLY_DELETED;
		}
		else{
			echo INFO_MESSAGE_DB_ACTION_FAILED;
		}
		break;
		
		
		
	case 'update_attributes_in_prod_info':
		$product_id = $_POST['product_id'];
		
		$attr_id_array = explode(",", $_POST['joined_attr_id_array']);
		$value_array = explode(",", $_POST['joined_value_array']);
		
		$succeed = true;
		foreach ($attr_id_array as $ind => $attr_id){
			$value = $value_array[$ind];
			if(!productInfo::update($product_id, $attr_id, $value)){
				$succeed = false;
			}
		}
		if($succeed){
			echo INFO_MESSAGE_PRODUCT_UPDATE_SUCCESSFUL;
		}
		else{
			echo INFO_MESSAGE_PRODUCT_UPDATE_FAILED;
		}

		break;

		
	case 'edit_product':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$contract_periode = $_POST['contract_periode'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		$active = $_POST['active'];

		$product_data = array("language_id"=>$language_id,
				"title"=>$title,
				"contract_periode"=>$contract_periode,
				"description"=>$description,
				"quantity"=>$quantity,
				"price"=>$price,
				"active"=>$active);

		if(product::productExists($product_data, $product_id)){
			echo INFO_MESSAGE_PRODUCT_ALREADY_EXISTS;
		}
		else{
			$product = new product($product_id, $language_id);
			if($product->update($product_data)){
				echo INFO_MESSAGE_PRODUCT_UPDATE_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_PRODUCT_UPDATE_FAILED;
			}

		}
		echo '</fieldset>';
		echo '</div>';
		break;


	case 'open_translate_product_form':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];

		$product = new product($product_id, $language_id);

		echo $product->printFormTranslate(language::printLanguages());

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'translate_product':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$contract_periode = $_POST['contract_periode'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		$active = $_POST['active'];

		$product_data = array(
				"product_id"=>$product_id,
				"language_id"=>$language_id,
				"title"=>$title,
				"contract_periode"=>$contract_periode,
				"description"=>$description,
				"quantity"=>$quantity,
				"price"=>$price,
				"active"=>$active);
				

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
		echo '</fieldset>';
		echo '</div>';
		break;


	case 'open_create_product_form':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo product::printCreateProductForm(language::printLanguages());

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'create_new_product':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
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

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'change_product_state':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
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
		echo '</fieldset>';
		echo '</div>';
		break;


	case 'delete_product':
		echo'<h1>'.LABEL_MY_PRODUCTS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_id = $_POST['product_id'];
		$language_id = $_POST['language_id'];
		$product = new product($product_id, $language_id);

		if($product->delete()){
			echo INFO_MESSAGE_PRODUCT_SUCCESSFULLY_DELETED;
		}
		else{
			echo INFO_MESSAGE_DB_ACTION_FAILED;
		}
			
		echo '</fieldset>';
		echo '</div>';
		break;

	case 'get_product_attributes_overview':
		echo'<h1>'.LABEL_MY_PRODUCTATTRIBUTES.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$shown_language_id = language::getShownLanguageId();
		$id_language_map = language::getIdLanguageMap();
		echo productattribute::printOverview($shown_language_id, $id_language_map);

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_create_attribute_form':
		echo'<h1>'.LABEL_MY_PRODUCTATTRIBUTES.'</h1>';
		echo'<div class="whitebox internal">';
		echo productAttribute::printCreateAttributeForm(language::printLanguages());
		echo '</fieldset>';
		echo '</div>';
		break;
	
	case 'create_new_attribute':
		$language_id = $_POST['language_id'];
		$description = $_POST['description'];
		$product_attribute_data = array();
		$product_attribute_data['product_attribute_id'] = NULL;
		$product_attribute_data['language_id'] = $language_id;
		$product_attribute_data['description'] = $description;
		
		if(productAttribute::descriptionAlreadyExists($language_id, $description)){
			echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_ALREADY_EXISTS;
		}
		else{
			if(productAttribute::create($product_attribute_data)){
				echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_FAILED;
			}
		}
		break;
		
	case 'delete_product_attribute':
		$product_attribute_id = $_POST['product_attribute_id'];
		$language_id = $_POST['language_id'];
		$product_attribute = new productAttribute($product_attribute_id, $language_id);
		if($product_attribute->delete() AND productInfo::deleteAllProductInfosByAttrId($product_attribute_id)){

			echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_SUCCESSFULLY_DELETED;
		}
		else{
			echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_DELETION_FAILED;
		}
		break;

	case 'open_product_attribute_editor':
		echo'<h1>'.LABEL_MY_PRODUCTATTRIBUTES.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$product_attribute_id = $_POST['product_attribute_id'];
		$language_id = $_POST['language_id'];
		$product_attribute = new productAttribute($product_attribute_id, $language_id);
		$language_ids_for_existing_product_attributes = $product_attribute->getLanguagesForExistingProductAttr($product_attribute_id);

		echo $product_attribute->printFormEdit(language::printLanguages($language_ids_for_existing_product_attributes, $language_id));

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'save_changed_product_attribute':
		$product_attribute_id = $_POST['product_attribute_id'];
		$language_id = $_POST['language_id'];
		$description = $_POST['description'];
		$changed_atribute_data = array("language_id"=>$language_id, "description"=>$description);
		
		if(productAttribute::productAttributeExists($changed_atribute_data, $product_attribute_id)){
			echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_ALREADY_EXISTS;
		}
		else{
			$product_attribute = new productAttribute($product_attribute_id, $language_id);
			;
			
			if($product_attribute->update($description)){
				echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_SUCCESSFUL;
			}
			else{
				echo INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_FAILED;
			}
				
			
		}
		
		break;
		

	case 'get_server_overview':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo server::printOverview();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_create_server_form':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo server::printCreateServerForm();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'create_new_server':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
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

		echo '</fieldset>';
		echo '</div>';
		break;



	case 'open_server_editor':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$server_id = $_POST['server_id'];

		$server = new server($server_id);

		echo $server->printEditServerForm();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'edit_server':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
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

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'delete_server':
		echo'<h1>'.LABEL_MY_SERVERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$server_id = $_POST['server_id'];

		$server = new server($server_id);
		$server->delete();

		echo '</fieldset>';
		echo '</div>';
		break;


	case 'get_customers_overview':
		echo'<h1>'.LABEL_MY_CUSTOMERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo customer::printOverview();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_customer_editor':
		echo'<h1>'.LABEL_MY_CUSTOMERS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		$customer_id = $_POST['customer_id'];

		$customer = new customer($customer_id);

		echo $customer->printFormEdit();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'get_content_overview':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';

		echo content::printOverview();

		echo '<div id="new_content_buttons"><a href="#" id="create_new_content" class="button_style">'. BUTTON_CREATE_CONTENT .'</a></div>';

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_new_content_editor':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$echo_string = '<form><div id="new_content_title"><input type="text" id="title" /></div>';
		$echo_string = $echo_string .'<div id="new_content_text"><textarea id="text" class="editor"></textarea></div>';
			
		$echo_string = $echo_string . language::printLanguages();

		$echo_string = $echo_string .'<div id="new_content_buttons"><input type="submit" id="create_content" value="'. BUTTON_SAVE .'"></div></form>';
			
		echo $echo_string;

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'open_content_editor':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
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

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'update_content':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$text = $_POST['text'];

		$content = new content($content_id, $language_id);
		$content->update($title, $text, $language_id);
		
		echo '</fieldset>';
		echo '</div>';
		break;

	case 'create_content':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$language_id = $_POST['language_id'];
		$title = $_POST['title'];
		$text = $_POST['text'];

		content::create($title, $text, $language_id);

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'delete_content':
		echo'<h1>'.LABEL_MY_CONTENT.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$content_id = $_POST['content_id'];
		$language_id = $_POST['language_id'];

		$content = new content($content_id, $language_id);
		$content->delete($language_id);

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'get_invoice_overview':
		echo'<h1>'.LABEL_MY_INVOICES.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo invoice::printOverviewBackend();

		echo '</fieldset>';
		echo '</div>';
		break;

	case 'change_invoice_status':
		echo'<h1>'.LABEL_MY_INVOICES.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		$invoice_id = $_POST['invoice_id'];
		$status_id = $_POST['status_id'];

		if(isset($invoice_id) && isset($status_id) ) {
			$invoice = new invoice( (int) $invoice_id);
			$invoice->setStatus($status_id);
		}
			
		echo '</fieldset>';
		echo '</div>';
		break;

	case 'get_statistic_overview':
		echo'<h1>'.LABEL_MY_STATISTICS.'</h1>';
		echo'<div class="whitebox internal">';
		echo'<fieldset>';
		
		echo '</fieldset>';
		echo '</div>';
		break;

}
echo '</div>';

?>
