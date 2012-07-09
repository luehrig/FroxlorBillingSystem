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
if(customer::isLoggedIn( session_id() ) || $action = 'send_email') {

	$action = $_POST['action'];

	switch($action) {

		case 'show_customer_header':

			$customer = new customer($_SESSION['customer_id']);
			$data = $customer->getData();

			echo MSG_CUSTOMER_WELCOME .', '. $data['first_name'] .' '. $data['last_name'] .'!';
			echo '<a href="#" id="logout"><img src="images/logout.png" id="logout" title="'. BUTTON_LOGOUT_CUSTOMER .'"></a>';

			break;

		case 'get_customer_data':

			$customer_id = $_SESSION['customer_id'];

			$customer = new customer($customer_id);

			echo $customer->printForm();

			break;

		case 'get_customer_data_headline':

			echo '<h1>'.PAGE_TITLE_CUSTOMERDATA.'</h1>';

			break;

		case 'get_edit_customer_data':

			$customer_id = $_SESSION['customer_id'];

			$customer = new customer($customer_id);

			echo $customer->printFormEdit();

			break;

		case 'get_customer_products':

			$customer_id = $_SESSION['customer_id'];

			echo contract::printOverviewCustomer($customer_id);

			break;

		case 'get_customer_products_headline':

			echo '<h1>'.PAGE_TITLE_CUSTOMERPRODUCTS.'</h1>';

			break;

		case 'get_customer_invoices':

			$customer_id = $_SESSION['customer_id'];

			$customer = new customer($customer_id);

			// content
			echo invoice::printOverviewCustomer($customer_id);

			break;

		case 'get_customer_invoices_headline':

			echo '<h1>'.PAGE_TITLE_CUSTOMERINVOICES.'</h1>';

			break;


		case 'send_email':
			// read post variables from request
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$customer_email = $_POST['email'];
			$msg_type = $_POST['msg_type'];
			$message = $_POST['message'];

			// get admin email address
			$customizing = new customizing();

			// full name
			$full_name = $first_name.' '.$last_name;
			
			// create subject text: message type (question/problem/feedbacke) + name
			$subject = $msg_type. ' / ' . $first_name .' '. $last_name;

			// if no smtp server credentials were entered in configuration.inc.php use standard mail function
			if(SMTP_SERVER == '' && SMTP_USER == '' && SMTP_PASSWORD == '') {
					
				$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
					
				// send message to customer
				try {
					$mail->AddAddress( $customer_email, $full_name );
					$mail->SetFrom( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->Send();
					echo "Message Sent OK</p>\n";
				} catch (phpmailerException $e) {
					//echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
					//echo $e->getMessage(); //Boring error messages from anything else!
				}
					
				
				// send message to admin
				try {
					$mail->AddAddress( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->SetFrom( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->Send();
					echo "Message Sent OK</p>\n";
				} catch (phpmailerException $e) {
					//echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
					//echo $e->getMessage(); //Boring error messages from anything else!
				}
				
			}
			else {
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
					
				$mail->IsSMTP(); // telling the class to use SMTP
				
				// send message to customer
				try {
					$mail->Host       = SMTP_SERVER; // SMTP server
					//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->Host       = SMTP_SERVER; // sets the SMTP server
					$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
					$mail->Username   = SMTP_USER; // SMTP account username
					$mail->Password   = SMTP_PASSWORD;        // SMTP account password
					$mail->AddAddress( $customer_email, $full_name );
					$mail->SetFrom( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->CharSet 	  = 'utf-8';
					$mail->Subject 	  = $subject;
					$mail->Body 	  = $message;
					$mail->Send();
				} catch (phpmailerException $e) {
					//echo $e->errorMessage();
				} catch (Exception $e) {
					//echo $e->getMessage();
				}
				
				
				// send message to shop admin
				try {
					$mail->Host       = SMTP_SERVER; // SMTP server
					//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->Host       = SMTP_SERVER; // sets the SMTP server
					$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
					$mail->Username   = SMTP_USER; // SMTP account username
					$mail->Password   = SMTP_PASSWORD;        // SMTP account password
					$mail->AddAddress( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->SetFrom( $customizing->getCustomizingValue('business_company_email') , $customizing->getCustomizingValue('business_company_name') );
					$mail->CharSet 	  = 'utf-8';
					$mail->Subject 	  = $subject;
					$mail->Body 	  = $message;
					$mail->Send();
				} catch (phpmailerException $e) {
					//echo $e->errorMessage();
				} catch (Exception $e) {
					//echo $e->getMessage();
				}
					
			}

			break;
	}

}


else {
	echo WARNING_NOT_LOGGED_IN;

}

?>