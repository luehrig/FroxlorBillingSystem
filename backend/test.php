<?php 

 error_reporting(E_ALL);
 ini_set('display_errors','On');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>

<link rel="stylesheet" href="css/style.css" type="text/css">

<script language="javascript" src="js/jquery-1.7.2.min.js"></script>

</head>
<body>


<?php

// Include the CKEditor class.
include("ckeditor/ckeditor.php");

// Create a class instance.
$CKEditor = new CKEditor();

// Path to the CKEditor directory.
$CKEditor->basePath = 'ckeditor/';

// Replace all textarea elements with CKEditor.
$CKEditor->replaceAll();
?>

<textarea name="testtext"></textarea>

</body>
</html>