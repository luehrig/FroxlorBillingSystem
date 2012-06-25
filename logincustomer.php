<?php
session_start();

include_once 'configuration.inc.php';

require PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);



include_once PATH_INCLUDES .'database_tables.php';
//include_once PATH_LANGUAGES .'DE.inc.php';


require PATH_FUNCTIONS .'general.php';


require PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';

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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo PAGE_TITLE_LOGIN_CUSTOMER; ?></title>
<script language="javascript" src="<?php echo BASE_DIR; ?>js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="<?php echo BASE_DIR; ?>js/general.js"></script>
</head>


<body>
<div id="messagearea"></div> 
<div class="colorboxwrapper">   
	<form method="post" action="#" id="loginform" class="loginform" accept-charset=utf-8>
	    <fieldset>
	    	<legend>
	    		<img ID="minilogo" src="images/logos/logo.png">
	    		<?php echo FIELDSET_LOGIN_FORM_CUSTOMER; ?>
	    	</legend>
	    	<label for="email"><?php echo LABEL_EMAIL; ?></label>
	    	<input type="text" id="email" name="email" rel="mandatory"><br>
	    	<label for="password"><?php echo LABEL_PASSWORD; ?></label>
	    	<input type="password" id="password" name="password" rel="mandatory">    	
	 		
	 		<input type="submit" id="ajaxlogin" name="ajaxlogin" value="<?php echo BUTTON_LOGIN_CUSTOMER; ?>">   
	    </fieldset>  
	</form>
	

	<div id="register">
		<a href="#!page=registration&lang=" id="registration" rel="<?php echo $site_language; ?>"><span><?php echo LINK_REGISTRATION; ?></span></a>
	</div>
	
</div>
</body>
</html>