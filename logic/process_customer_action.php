<?php

include_once '../configuration.inc.php';

require_once PATH_FUNCTIONS .'datetime.php';

require_once PATH_EXT_LIBRARIES .'phpmailer/class.phpmailer.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customer.php';
require_once PATH_CLASSES .'cl_invoice.php';
require_once PATH_CLASSES .'cl_order.php';
require_once PATH_CLASSES .'cl_country.php';
require_once PATH_CLASSES .'cl_currency.php';
require_once PATH_CLASSES .'cl_contract.php';

if(session_id() == '') {
	session_start();
}

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

$customizing = new customizing( language::getBrowserLanguage() );

if(!isset($language_id)) {
	// check if language was handed over
	if(isset($_POST['language_id'])) {
		$language_id = language::ISOTointernal($_POST['language_id']);
		if($language_id == null) {
			$language_id = language::ISOTointernal( language::getBrowserLanguage() );
		}
	}
	else {
		$language_id = language::ISOTointernal( language::getBrowserLanguage() );
	}
}

include_once PATH_LANGUAGES . strtoupper( language::internalToISO($language_id) ) .'.inc.php';

// check if customer is logged in
if(customer::isLoggedIn( session_id() )) {

	$action = $_POST['action'];

	switch($action) {

		case 'show_customer_header':

			$customer = new customer($_SESSION['customer_id']);
			$data = $customer->getData();

			echo MSG_CUSTOMER_WELCOME .', '. $data['first_name'] .' '. $data['last_name'] .'!';
			echo '<a href="#" id="logout"> '. BUTTON_LOGOUT_CUSTOMER .'</a>';

			break;

		case 'get_customer_data':

			$customer_id = $_SESSION['customer_id'];

			echo '<div class="whitebox">';
			echo '<div class="cust_data">';

			echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';

			$customer = new customer($customer_id);

			echo $customer->printForm();

			echo '</div>';
			echo '</div>';

			break;

		case 'get_edit_customer_data':

			$customer_id = $_SESSION['customer_id'];

			echo '<div class="whitebox">';
			echo '<div class="cust_data">';

			echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';

			$customer = new customer($customer_id);

			echo $customer->printFormEdit();

			echo '</div>';
			echo '</div>';

			break;

		case 'get_customer_products':

			$customer_id = $_SESSION['customer_id'];

			echo '<div class="whitebox">';
			echo '<div class="cust_data">';

			echo '<h1>'.PAGE_TITLE_CUSTOMERPRODUCTS.'</h1>';

			echo contract::printOverviewCustomer($customer_id);

			echo '</div>';
			echo '</div>';

			break;

		case 'get_customer_invoices':

			$customer_id = $_SESSION['customer_id'];

			echo '<div class="whitebox">';
			echo '<div class="cust_data">';

			echo '<h1>'.PAGE_TITLE_CUSTOMERINVOICES.'</h1>';

			$customer = new customer($customer_id);

			// content
			echo invoice::printOverviewCustomer($customer_id);

			echo '</div>';
			echo '</div>';

			break;

		case 'send_email':
	
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$customer_email = $_POST['email'];
		$msg_type = $_POST['msg_type'];
		$message = $_POST['message'];
// 		$customer_id = $_POST['customer_id'];
		
		// get admin email address
		$customizing = new customizing();
		$customizing_entries = $customizing->getCustomizingComplete();
		$recipient = $customizing_entries['business_company_email'];
		
		// full name
		$full_name = $first_name.' '.$last_name;
		
		// create subject text: message type (question/problem/feedbacke) + name
		$subject = $msg_type. ' / ' . $first_name .' '. $last_name;
		
		// if no smtp server credentials were entered in configuration.inc.php use standard mail function
		if(SMTP_SERVER == '' && SMTP_USER == '' && SMTP_PASSWORD == '') {
		
			$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
		
			// send invoice to customer
			try {
				$mail->AddAddress( $recipient, $customizing->getCustomizingValue('business_company_name') );
				$mail->SetFrom( $customer_email , $full_name );
				$mail->Subject = $subject;
				$mail->Send();
				echo MSG_SUCCESSFULLY_SENT;
			} catch (phpmailerException $e) {
				//echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				//echo $e->getMessage(); //Boring error messages from anything else!
			}
		}
		else {
			//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
			$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		
			$mail->IsSMTP(); // telling the class to use SMTP
		
			// send invoice to customer
			try {
				$mail->Host       = SMTP_SERVER; // SMTP server
				//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Host       = SMTP_SERVER; // sets the SMTP server
				$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
				$mail->Username   = SMTP_USER; // SMTP account username
				$mail->Password   = SMTP_PASSWORD;        // SMTP account password
				$mail->AddAddress( $recipient, $customizing->getCustomizingValue('business_company_name') );
				$mail->SetFrom( $customer_email , $full_name );
				$mail->Subject = $subject;
				$mail->Send();
				echo MSG_SUCCESSFULLY_SENT;
			} catch (phpmailerException $e) {
				//echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				//echo $e->getMessage(); //Boring error messages from anything else!
			}
		}	

		break;
	}

}


else {
	echo WARNING_NOT_LOGGED_IN;
	
}

?>