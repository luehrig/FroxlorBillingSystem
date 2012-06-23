<?php

require_once 'cl_customizing.php';
require_once 'cl_invoice.php';

class communication {

	private $company_email;
	private $billing_sender;

	/* constructor */
	public function __construct() {
		// load information from customizing
		$this->load();
	}



	/* public section */
	public function sendInvoice($invoice_id) {

		$customizing = new customizing();
		$invoice = new invoice($invoice_id);
		$customer = new customer($invoice->getCustomerID());

		$invoice_file = $invoice->downloadInvoice();
		
		// if no smtp server credentials were entered in configuration.inc.php use standard mail function
		if(SMTP_SERVER == '' && SMTP_USER == '' && SMTP_PASSWORD == '') {
				
			$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
				
			// send invoice to customer
			try {
				$mail->AddAddress( $customer->getEMail(), $customer->getFullName() );
				$mail->SetFrom( $customizing->getCustomizingValue('business_company_billing_sender') , $customizing->getCustomizingValue('business_company_name') );
				$mail->Subject = sprintf( LABEL_COMMUNICATION_INVOICE_SUBJECT, $invoice->getInvoiceNumber() );
				$mail->AltBody = NOTICE_COMMUNICATION_HTML_EMAIL; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML('Ihre Rechnung!');
				$mail->AddAttachment( $invoice_file, $invoice->getInvoiceNumber() .'.pdf' );      // attachment
				$mail->Send();
				echo "Message Sent OK</p>\n";
			} catch (phpmailerException $e) {
				//echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				//echo $e->getMessage(); //Boring error messages from anything else!
			}
			
			// send invoice to shop owner
			try {
				$mail->AddAddress( $customizing->getCustomizingValue('business_company_email'), $customizing->getCustomizingValue('business_company_name') );
				$mail->SetFrom( $customizing->getCustomizingValue('business_company_billing_sender') , $customizing->getCustomizingValue('business_company_name') );
				$mail->Subject = sprintf( LABEL_COMMUNICATION_INVOICE_SUBJECT_ADMIN, $invoice->getInvoiceNumber() );
				$mail->AltBody = NOTICE_COMMUNICATION_HTML_EMAIL; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML('Neue Rechnung vom Kunden.');
				$mail->AddAttachment( $invoice_file, $invoice->getInvoiceNumber() .'.pdf' );      // attachment
				$mail->Send();
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
				$mail->AddAddress( $customer->getEMail(), $customer->getFullName() );
				$mail->SetFrom( $customizing->getCustomizingValue('business_company_billing_sender') , $customizing->getCustomizingValue('business_company_name') );
				$mail->Subject = sprintf( LABEL_COMMUNICATION_INVOICE_SUBJECT, $invoice->getInvoiceNumber() );
				$mail->AltBody = NOTICE_COMMUNICATION_HTML_EMAIL; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML('Ihre Rechnung!');
				$mail->AddAttachment( $invoice_file, $invoice->getInvoiceNumber() .'.pdf' ); // attachment
				$mail->Send();
			} catch (phpmailerException $e) {
				//echo $e->errorMessage();
			} catch (Exception $e) {
				//echo $e->getMessage();
			}
			
			// send invoice to shop owner
			try {
				$mail->Host       = SMTP_SERVER; // SMTP server
				//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Host       = SMTP_SERVER; // sets the SMTP server
				$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
				$mail->Username   = SMTP_USER; // SMTP account username
				$mail->Password   = SMTP_PASSWORD;        // SMTP account password
				$mail->AddAddress( $customizing->getCustomizingValue('business_company_email'), $customizing->getCustomizingValue('business_company_name') );
				$mail->SetFrom( $customizing->getCustomizingValue('business_company_billing_sender') , $customizing->getCustomizingValue('business_company_name') );
				$mail->Subject = sprintf( LABEL_COMMUNICATION_INVOICE_SUBJECT_ADMIN, $invoice->getInvoiceNumber() );
				$mail->AltBody = NOTICE_COMMUNICATION_HTML_EMAIL; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML('Neue Rechnung vom Kunden.');
				$mail->AddAttachment( $invoice_file, $invoice->getInvoiceNumber() .'.pdf' ); // attachment
				$mail->Send();
			} catch (phpmailerException $e) {
				//echo $e->errorMessage();
			} catch (Exception $e) {
				//echo $e->getMessage();
			}
		}

		// delete invoice file after processing
		unlink($invoice_file);
	}



	/* private section */
	private function load() {
		$customizing = new customizing();
		$this->company_email = $customizing->getCustomizingValue('business_company_email');
		$this->billing_sender = $customizing->getCustomizingValue('business_company_billing_sender');
	}


}

?>