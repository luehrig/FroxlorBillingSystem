<?php 
	include_once 'configuration.inc.php';
	
	require 'functions/database.php';
	db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
	
	
	
	include_once 'includes/database_tables.php';
	include_once 'includes/languages/german.php';
	
	
	require 'functions/general.php';
	require 'functions/user_management.php';

	require 'includes/classes/cl_country.php';
	
	$country = new country(1);
	
	//echo get_default_language();
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title><?php echo PAGE_TITLE_REGISTRATION; ?></title>
</head>
<body>
    
<form method="post" action="<?php echo $PHP_SELF;?>">
    <fieldset>
    <legend><?php echo FIELDSET_GENERAL_INFORMATION; ?></legend>
    	<label for="gender"><?php echo LABEL_GENDER; ?></label>
    	<select name="gender" id="gender" size="1">
      		<option><?php echo SELECT_GENDER_MALE; ?></option>
      		<option><?php echo SELECT_GENDER_FEMALE; ?></option>
    	</select>
    	<label for="title"><?php echo LABEL_TITLE; ?></label>
    	<input type="text" id="title" name="title">
    	<label for="company"><?php echo LABEL_COMPANY; ?></label>
    	<input type="text" id="company" name="company">
    	<label for="first_name"><?php echo LABEL_FIRST_NAME; ?></label>
    	<input type="text" id="first_name" name="first_name">
    	<label for="last_name"><?php echo LABEL_LAST_NAME; ?></label>
    	<input type="text" id="last_name" name="last_name">
    	<label for="password"><?php echo LABEL_PASSWORD; ?></label>
    	<input type="password" id="password" name="password">
    </fieldset>
    <fieldset>
    <legend><?php echo FIELDSET_CONTACT_INFORMATION; ?></legend>
    	<label for="email"><?php echo LABEL_EMAIL; ?></label>
    	<input type="text" id="email" name="email">
    	<label for="telephone"><?php echo LABEL_TELEPHONE; ?></label>
    	<input type="text" id="telephone" name="telephone">
    	<label for="fax"><?php echo LABEL_FAX; ?></label>
    	<input type="text" id="fax" name="fax">
    </fieldset>
    <fieldset>
    <legend><?php echo FIELDSET_ADDRESS_INFORMATION; ?></legend>
    	<div id="shippingaddress">
    		<label for="shippingstreet"><?php echo LABEL_STREET; ?></label>
    		<input type="text" id="shippingstreet" name="shippingstreet">
    		<label for="shippingstreetnumber"><?php echo LABEL_STREETNUMBER; ?></label>
    		<input type="text" id="shippingstreetnumber" name="shippingstreetnumber">
    		<label for="shippingpostcode"><?php echo LABEL_POSTCODE; ?></label>
    		<input type="text" id="shippingpostcode" name="shippingpostcode">
    		<label for="shippingcity"><?php echo LABEL_CITY; ?></label>
    		<input type="text" id="shippingcity" name="shippingcity">
    		<label for="shippingcountry"><?php echo LABEL_COUNTRY; ?></label>
    		<?php $country->printSelectBox("shippingcountry"); ?>
    	</div>
    	<div id="billingaddress"></div>
    </fieldset>	
    
    
    
</form>
    
</body>
</html>