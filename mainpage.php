<div class="content_container" id="content_container">
<?php 
/*
 * this coding is neccessary to support google ajax crawling
 * 
 * receive special masked url and print content as static page
 */
if(isset($_GET['_escaped_fragment_'])) {
	
	$action = 'show_'. substr($_GET['_escaped_fragment_'], 0);
	
	if(isset($_GET['lang'])) {
		$language_id = language::ISOTointernal($_GET['lang']);
	}
	else {
		$language_id = language::ISOTointernal(language::getBrowserLanguage());
	}	
	
	include_once 'logic/process_content_handling.php';
}

?>

</div>
