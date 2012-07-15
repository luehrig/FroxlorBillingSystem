<?php
//session_start();

include_once '../configuration.inc.php';

//require 'functions/database.php';
//db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);



include_once '../includes/database_tables.php';
//include_once 'includes/languages/DE.inc.php';


require_once '../functions/general.php';
require_once '../functions/user_management.php';

require_once '../includes/classes/cl_country.php';

$country = new country( get_default_language() );

require_once '../includes/classes/cl_customizing.php';
require_once '../includes/classes/cl_language.php';

/* if(!isset($_SESSION['customizing'])) { */
$customizing = new customizing( get_default_language() );
$_SESSION['customizing'] = $customizing;
/* } */

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

?>

	<h1>
		<?php echo PAGE_TITLE_REGISTRATION; ?>
	</h1>
	<div id="messagearea"></div>
	<form method="post" action="#" id="registrationform" class="registrationform"
		accept-charset=utf-8>
		<div class="registrationform">
		<div class="boxwrapper">
			<div class=" whitebox box_1inRow">
			<fieldset>
				<legend>
					<?php echo FIELDSET_GENERAL_INFORMATION; ?>
				</legend>
				<p>
					<label for="gender"><?php echo LABEL_GENDER; ?> </label> <select
						name="gender" id="gender" size="1" rel="mandatory">
						<option value="" style="display: none;"></option>
						<option
							id="<?php echo $customizing->getCustomizingValue('sys_gender_male'); ?>"
							name="gender">
							<?php echo SELECT_GENDER_MALE; ?>
						</option>
						<option
							id="<?php echo $customizing->getCustomizingValue('sys_gender_female'); ?>"
							name="gender">
							<?php echo SELECT_GENDER_FEMALE; ?>
						</option>
					</select>
				
					<label for="title"><?php echo LABEL_TITLE; ?> </label> <input
						type="text" id="title" name="title">
				</p>	
				<p>
					<label for="first_name"><?php echo LABEL_FIRST_NAME; ?> </label> <input
						type="text" id="first_name" name="first_name" rel="mandatory">
					<label for="last_name"><?php echo LABEL_LAST_NAME; ?> </label> <input
						type="text" id="last_name" name="last_name" rel="mandatory">
				</p>
				<p>
					<label for="company"><?php echo LABEL_COMPANY; ?> </label> <input
						type="text" id="company" name="company">
				</p>
				<br>
				<p>
					<label for="password"><?php echo LABEL_PASSWORD; ?> </label> <input
						type="password" id="password" name="password" rel="mandatory">
				</p>
				<p>
					<label for="password"><?php echo LABEL_PASSWORDAGAIN; ?> </label> <input
						type="password" id="passwordagain" name="passwordagain"
						rel="mandatory">
				</p>
			</fieldset>
			</div>
			<div class=" whitebox box_1inRow">
			<fieldset>
				<legend>
					<?php echo FIELDSET_CONTACT_INFORMATION; ?>
				</legend>
				<p>
					<label for="email"><?php echo LABEL_EMAIL; ?> </label> <input
						type="email" id="email" name="email" rel="mandatory">
				</p>
				<p>
					<label for="telephone"><?php echo LABEL_TELEPHONE; ?> </label> <input
						type="text" id="telephone" name="telephone">
				</p>
				<p>
					<label for="fax"><?php echo LABEL_FAX; ?> </label> <input
						type="text" id="fax" name="fax">
				</p>
			</fieldset>
			</div>
			<div class=" whitebox box_1inRow">
			<fieldset>
				<legend>
					<?php echo SHIPPING_ADDRESS; ?>
				</legend>
				<div id="shippingaddress">
					<p>
						<label for="shippingstreet"><?php echo LABEL_STREET; ?> </label> <input
							type="text" id="shippingstreet" name="shippingstreet"
							rel="mandatory">
						<label for="shippingstreetnumber" class="streetnumber"><?php echo LABEL_STREETNUMBER; ?>
						</label> <input type="text" id="shippingstreetnumber" class="streetnumber"
							name="shippingstreetnumber" rel="mandatory">
					</p>
					<p>
						<label for="shippingpostcode"><?php echo LABEL_POSTCODE; ?> </label>
						<input type="text" id="shippingpostcode" class="postcode" name="shippingpostcode"
							rel="mandatory">
						<label for="shippingcity" class="city"><?php echo LABEL_CITY; ?> </label> <input
							type="text" id="shippingcity" class="city" name="shippingcity" rel="mandatory">
					</p>
					<p>
						<label for="shippingcountry"><?php echo LABEL_COUNTRY; ?> </label>
						<?php echo $country->printSelectBox("shippingcountry","shippingcountry"); ?>
					</p>
				</div>
				<div id="billingaddress"></div>
		
		</div>
		</fieldset>
		</div>

		<input type="reset" id="clear" name="clear" value="<?php echo BUTTON_RESET; ?>"> <input type="submit"
			id="register" name="register"
			value="<?php echo BUTTON_CREATE_ACCOUNT; ?>">
	</div>	

	</form>

</body>
</html>