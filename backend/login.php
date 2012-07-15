<?php
session_start();

include_once '../configuration.inc.php';

require PATH_FUNCTIONS .'general.php';
require PATH_FUNCTIONS .'database.php';

// open db connection
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_CLASSES .'cl_customizing.php';
include_once PATH_CLASSES .'cl_language.php';
include_once PATH_INCLUDES .'database_tables.php';


// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();
include_once PATH_LANGUAGES . strtoupper($site_language) .'.inc.php';


$customizing = new customizing( get_default_language() );
$_SESSION['customizing'] = $customizing;
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo PAGE_TITLE_LOGIN_BACKEND; ?></title>
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script language="javascript" src="js/admin.js"></script>

<link rel="stylesheet" href="../css/style.css" media="screen and (min-device-width: 600px)" type="text/css" />
<link rel="stylesheet" href="../css/colorbox.css" type="text/css">

<link rel="SHORTCUT ICON" href="../images/logos/favicon.ico" type="image/x-icon">

</head>
<body>
<div class="header">
	<img ID="logo" src="../images/fcloud.png">
</div>

<div class="mainmenu">
	<ul></ul>
</div>

<div class="content_container" id="content_container">
	<div class="boxwrapper">
		<div class=" whitebox box_1inRow">
			
			<div id="messagearea"></div>    
			<form method="post" action="#" id="loginformbackend" accept-charset=utf-8>
			    <fieldset>
			    <legend><?php echo FIELDSET_LOGIN_FORM_BACKEND; ?></legend>
			    	<label for="email"><?php echo LABEL_EMAIL; ?></label>
			    	<input type="text" id="email" name="email" rel="mandatory"><br>
			    	<label for="password"><?php echo LABEL_PASSWORD; ?></label>
			    	<input type="password" id="password" name="password" rel="mandatory">    	
			    </fieldset>
			    
			    <input type="submit" id="login" name="login" value="<?php echo BUTTON_LOGIN_BACKEND; ?>">    
			</form>
	
		</div>
	</div>
</div>

<div class="footer">
	&copy; by Max L&uumlhrig, Jana Keim, Josh Frey, Erol G&uumll. All rights reserved.
	<img ID="froxcloud_white" src="../images/logos/froxcloud_white.png">
</div>
    
</body>
</html>