<div class="content_container">

<?php 
/*
 * this coding is neccessary to support google ajax crawling
 * 
 * receive special masked url and print content as static page
 */
if(isset($_GET['_escaped_fragment_'])) {
	
	$action = 'show_'. substr($_GET['_escaped_fragment_'], 5);
	
	$language_id = language::ISOTointernal($_GET['lang']);
	
	include_once 'logic/process_content_handling.php';
}

?>

</div>