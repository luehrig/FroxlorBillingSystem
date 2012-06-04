<?php 

require '../includes/classes/cl_customizing.php';

session_start();

include_once '../configuration.inc.php';

require '../functions/database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

include_once '../includes/database_tables.php';
include_once '../includes/languages/DE.inc.php';
include_once '../functions/user_management.php';

if(!db_user_is_logged_in( session_id() )) {
	header ("Location: login.php");
	exit();
}
else {
	echo 'Herzlich Willkommen im internen Bereich!';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Froxcloud</title>

<link rel="stylesheet" href="../css/style.css" type="text/css">

<script language="javascript" src="../js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="../js/customercenter.js"></script>

</head>
<body>
<div class="header">
	<img ID="logo" src="../images/fcloud.png">

	<a href="#" id="logout">Abmelden</a>
	
</div>
