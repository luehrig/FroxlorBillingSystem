<?php 

require '../includes/classes/cl_customizing.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';
include_once 'includes/languages/DE.inc.php';
include_once '../functions/user_management.php';

if(!db_backend_user_is_logged_in( session_id() )) {
	header ("Location: login.php");
	exit();
}
else {
	echo 'Herzlich Willkommen im internen Bereich für den Shopbetreiber!';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo PAGE_TITLE_SHOPMAINTENANCE_BACKEND; ?></title>

<link rel="stylesheet" href="css/style.css" type="text/css">

<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>

<script language="javascript" src="js/admin.js"></script>

</head>
<body>
<div class="header">
	<img ID="logo" src="../images/fcloud.png">

	<a href="#" id="logout"><?php echo BUTTON_LOGOUT_BACKEND; ?></a>
	
</div>
