<textarea name="testtext"></textarea>

<?php
// Include the CKEditor class.
include("ckeditor/ckeditor.php");

// Create a class instance.
$CKEditor = new CKEditor();

// Path to the CKEditor directory.
$CKEditor->basePath = '/ckeditor/';

// Replace all textarea elements with CKEditor.
$CKEditor->replaceAll();
?>

