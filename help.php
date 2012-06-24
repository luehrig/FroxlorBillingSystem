<?php 
include_once 'configuration.inc.php';
require PATH_CLASSES .'cl_language.php';
require PATH_CLASSES .'cl_customer.php';

require 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once 'includes/database_tables.php';

require 'functions/general.php';

// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();

include_once 'includes/languages/'. strtoupper($site_language) .'.inc.php';

'<script language="javascript" src="js/customercenter.js"></script>';

echo '	

<div class="colorboxwrapper">
	<form method="post" action="#" id="contact_message" accept-charset=utf-8>
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
				Kontakt
			</legend>
			<p>
				<label for="first_name">Vorname</label> 
				<input type="text" id="first_name" name="first_name" rel="mandatory">
			</p>
			<p>
				<label for="last_name">Nachname</label> 
				<input type="text" id="last_name" name="last_name" rel="mandatory">
			</p>
			<p>
				<label for="email">Email</label>';

				if(session_id() == ''){
					session_start();
				}
				$session = session_id();
				
				// If customer is logged in show customer's email adress in email input field
				if(customer::isLoggedIn($session)) {
				
					$customer = new customer($_SESSION['customer_id']);
					$data = $customer->getData();
					
					echo '<input type="email" id="email" name="email" rel="mandatory" value="'. $data['email'] .'">';
				}
				else{ // if not show empty input field
					echo '<input type="email" id="email" name="email" rel="mandatory">';
				}
			
echo		'</p>
			<p>
	    		<input type="radio" class="message_type" name="message_type" value="Frage">Frage
	    		<input type="radio" class="message_type" name="message_type" value="Probleme">Probleme
	    		<input type="radio" class="message_type" name="message_type" value="Feedback">Feedback
	  		</p>
	  		<p>
	  			<label for="textfeld">Deine Nachricht</label><br>
				<textarea id="message" cols="30" rows="4"></textarea><br> 	
				<input id="send_email" type="submit" value="Senden" />
				<input id="send_email" type="button" value="Senden" />
			</p>
			<div class="gesendet">
			</div>
		</fieldset>
	</form>
</div>

';?>






