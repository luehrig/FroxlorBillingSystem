<?php 

require_once  PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_customer.php';

require_once PATH_CLASSES .'cl_customizing.php';

require_once 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once 'includes/database_tables.php';

require_once 'functions/general.php';

// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();

include_once 'includes/languages/'. strtoupper($site_language) .'.inc.php';

'<script language="javascript" src="js/customercenter.js"></script>';

if(session_id() == ''){
	session_start();
}
$session = session_id();


$data = '';

if(customer::isLoggedIn($session)) {
		
	$customer = new customer($_SESSION['customer_id']);
	$data = $customer->getData();
	echo $data['first_name'];
}

echo '	
<h1>' .VIEW_MENU_CONTACT. '</h1>
<div class="colorboxwrapper_small">
<div class="whitebox">
	<div class="contact">
		<form method="post" action="#" id="contact_message" class="contact_message" accept-charset=utf-8>
			<fieldset>
				<legend>
					<img ID="minilogo" src="images/logos/logo.png">
					'. LEGEND_CONTACT_FORM .'
				</legend>
				<p>
					<label for="first_name">'. LABEL_FIRST_NAME .'</label>';
					
					// If customer is logged in show customer's first name in first name input field
					if($data != ''){
						echo'<input type="text" id="first_name" name="first_name" rel="mandatory" value="'. $data['first_name'] .'">';
					}
					else{ // if not show empty input field
						echo '<input type="text" id="first_name" name="first_name" rel="mandatory" value="blablabla">';
					} 
				echo'</p>
				<p>
					<label for="last_name">'. LABEL_LAST_NAME .'</label>';
					
					// If customer is logged in show customer's last name in last name input field
					if($data != ''){
						echo'<input type="text" id="last_name" name="last_name" rel="mandatory" value="'. $data['last_name'] .'">';
					} 
					else{ // if not show empty input field
						echo '<input type="text" id="last_name" name="last_name" rel="mandatory">';
					}
				echo'</p>
				<p>
					<label for="email">'. LABEL_EMAIL .'</label>';
	
					
					
					// If customer is logged in show customer's email adress in email input field
					if($data != ''){
						echo '<input type="email" id="email" name="email" rel="mandatory" value="'. $data['email'] .'">';
					}
					else{ // if not show empty input field
						echo '<input type="email" id="email" name="email" rel="mandatory">';
					}
				
			echo'</p>
				<p>
		    		<input type="radio" class="message_type" name="message_type" id="question" value="Frage" checked>'. RADIO_VALUE_QUESTION .'
		    		<input type="radio" class="message_type" name="message_type" id="problem" value="Probleme">'. RADIO_VALUE_PROBLEM .'
		    		<input type="radio" class="message_type" name="message_type" id="feedback" value="Feedback">'. RADIO_VALUE_FEEDBACK .'
		  		</p>
		  		<p>
		  			<label for="textfeld">'. LABEL_YOUR_MESSAGE .'</label><br>
					<textarea id="message" cols="30" rows="4"></textarea><br> 	
				</p>
				<input id="send_email" type="submit" value="'. LABEL_SEND .'" />
			</fieldset>
		</form>
	</div>
</div>	
</div>

';?>






