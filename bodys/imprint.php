<?php
if(!isset($_GET['page'])) {
	include_once '../configuration.inc.php';
}

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';

$content_id_for_imprint = 1;
$language_id = language::ISOTointernal(language::getBrowserLanguage());
$content = new content($content_id_for_imprint ,$language_id); 

$imprint_text = $content->getText($language_id);


echo '<h1>'. VIEW_MENU_IMPRINT .'</h1>'. '<div class="boxwrapper">'.

// 	<div class=" whitebox box_2inRow">
// 		<fieldset>
// 			<legend>
// 				<img ID="minilogo" src="images/logos/logo.png">
// 				Rechtliches
// 			</legend>
// 			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
// 		</fieldset>
// 	</div>
	
// 	<div class=" whitebox box_2inRow">
// 		<fieldset>
// 			<legend>
// 				<img ID="minilogo" src="images/logos/logo.png">
// 				Herzlich Willkommen
// 			</legend>
// 			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
// 		</fieldset>
// 	</div>
	
	'<div class=" whitebox box_1inRow">
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
			</legend>'.
			$imprint_text. 
		'</fieldset>
	</div>
	
</div>';

?>
