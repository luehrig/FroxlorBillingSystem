<?php 

include_once '../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';


session_start();


require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';
include_once '../functions/user_management.php';

if(!db_backend_user_is_logged_in( session_id() )) {
	header ("Location: login.php");
	exit();
}



// // // detect preferred browser language if language is not available use the default language from shop customizing
 $site_language = language::getBrowserLanguage();
 include_once '../includes/languages/'. strtoupper($site_language) .'.inc.php';


// detect preferred browser language if language is not available use the default language from shop customizing
$site_language = language::getBrowserLanguage();



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo PAGE_TITLE_SHOPMAINTENANCE_BACKEND; ?></title>

<!-- stylesheets for lightbox, printer and desktop screen -->
<link rel="stylesheet" href="../css/style.css" media="screen and (min-device-width: 600px)" type="text/css" />
<link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
<link rel="stylesheet" href="../css/colorbox.css" type="text/css">

<!-- stylesheet for mobile devices -->
<link type="text/css" rel="stylesheet" media="only screen and (max-device-width: 599px)" href="../css/handheld.css" />
<link rel="stylesheet" media="screen and (-webkit-device-pixel-ratio:0.75)" href="../css/handheld.css" />
<link rel="stylesheet" href="../css/handheld.css" media="handheld" type="text/css" />

<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script language="javascript" src="../js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
<script language="javascript" src="js/admin.js"></script>

<link rel="SHORTCUT ICON" href="../images/logos/favicon.ico" type="image/x-icon">

</head>
<body>
<div class="header">

	<img ID="logo" src="../images/fcloud.png">
	
 	<div class="header_right">
		<a class="admin_logout" href="#" id="logout"><img src="../images/logout.png" id="logout"><?php echo BUTTON_LOGOUT_BACKEND?></a>
		<div ID="admin_welcome"><?php echo MSG_BACKEND_WELCOME; ?>
		</div>
	</div>
</div>
