<?php
session_start();

include_once 'configuration.inc.php';

require 'functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);



include_once 'includes/database_tables.php';
include_once 'includes/languages/DE.inc.php';


require 'functions/general.php';
require 'functions/user_management.php';

require 'includes/classes/cl_country.php';

$country = new country( get_default_language() );

require 'includes/classes/cl_customizing.php';

/* if(!isset($_SESSION['customizing'])) { */
	$customizing = new customizing( get_default_language() );
	$_SESSION['customizing'] = $customizing;
/* } */
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo PAGE_TITLE_REGISTRATION; ?></title>
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>

<script language="javascript" src="js/general.js"></script>
</head>
<body>
<div id="messagearea"></div>    
<form method="post" action="#" id="registrationform" accept-charset=utf-8>
    <fieldset>
    <legend><?php echo FIELDSET_GENERAL_INFORMATION; ?></legend>
    	<label for="gender"><?php echo LABEL_GENDER; ?></label>
    	<select name="gender" id="gender" size="1" rel="mandatory">
      		<option value="" style="display:none;"></option>
      		<option id="<?php echo $customizing->getCustomizingValue('sys_gender_male'); ?>" name="gender"><?php echo SELECT_GENDER_MALE; ?></option>
      		<option id="<?php echo $customizing->getCustomizingValue('sys_gender_female'); ?>" name="gender"><?php echo SELECT_GENDER_FEMALE; ?></option>
    	</select>
    	<label for="title"><?php echo LABEL_TITLE; ?></label>
    	<input type="text" id="title" name="title">
    	<label for="company"><?php echo LABEL_COMPANY; ?></label>
    	<input type="text" id="company" name="company">
    	<label for="first_name"><?php echo LABEL_FIRST_NAME; ?></label>
    	<input type="text" id="first_name" name="first_name" rel="mandatory">
    	<label for="last_name"><?php echo LABEL_LAST_NAME; ?></label>
    	<input type="text" id="last_name" name="last_name" rel="mandatory">
    	<label for="password"><?php echo LABEL_PASSWORD; ?></label>
    	<input type="password" id="password" name="password" rel="mandatory">
    </fieldset>
    <fieldset>
    <legend><?php echo FIELDSET_CONTACT_INFORMATION; ?></legend>
    	<label for="email"><?php echo LABEL_EMAIL; ?></label>
    	<input type="text" id="email" name="email" rel="mandatory">
    	<label for="telephone"><?php echo LABEL_TELEPHONE; ?></label>
    	<input type="text" id="telephone" name="telephone">
    	<label for="fax"><?php echo LABEL_FAX; ?></label>
    	<input type="text" id="fax" name="fax">
    </fieldset>
    <fieldset>
    <legend><?php echo FIELDSET_ADDRESS_INFORMATION; ?></legend>
    	<div id="shippingaddress">
    		<label for="shippingstreet"><?php echo LABEL_STREET; ?></label>
    		<input type="text" id="shippingstreet" name="shippingstreet" rel="mandatory">
    		<label for="shippingstreetnumber"><?php echo LABEL_STREETNUMBER; ?></label>
    		<input type="text" id="shippingstreetnumber" name="shippingstreetnumber" rel="mandatory">
    		<label for="shippingpostcode"><?php echo LABEL_POSTCODE; ?></label>
    		<input type="text" id="shippingpostcode" name="shippingpostcode" rel="mandatory">
    		<label for="shippingcity"><?php echo LABEL_CITY; ?></label>
    		<input type="text" id="shippingcity" name="shippingcity" rel="mandatory">
    		<label for="shippingcountry"><?php echo LABEL_COUNTRY; ?></label>
    		<?php $country->printSelectBox("shippingcountry","shippingcountry"); ?>
    	</div>
    	<div id="billingaddress"></div>
    </fieldset>	
    
    <input type="reset" id="reset" name="reset">
    <input type="submit" id="register" name="register" value="<?php echo BUTTON_CREATE_ACCOUNT; ?>">
    
    
</form>
    
</body>
</html>