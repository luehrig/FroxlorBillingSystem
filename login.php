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
<title><?php echo PAGE_TITLE_LOGIN_CUSTOMER; ?></title>
<script language="javascript" src="js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="js/general.js"></script>
</head>
<body>
<div id="messagearea"></div>    
<form method="post" action="#" id="loginform" accept-charset=utf-8>
    <fieldset>
    <legend><?php echo FIELDSET_LOGIN_FORM_CUSTOMER; ?></legend>
    	<label for="email"><?php echo LABEL_EMAIL; ?></label>
    	<input type="text" id="email" name="email" rel="mandatory">
    	<label for="password"><?php echo LABEL_PASSWORD; ?></label>
    	<input type="password" id="password" name="password" rel="mandatory">    	
    </fieldset>
    
    <input type="submit" id="login" name="login" value="<?php echo BUTTON_LOGIN_CUSTOMER; ?>">    
</form>
    
</body>
</html>