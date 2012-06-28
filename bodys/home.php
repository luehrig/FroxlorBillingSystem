<?php 
		


require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customizing.php';

$language_id = language::ISOTointernal(language::getBrowserLanguage());

$customizing = new customizing($language_id);
$home_Customizing_key = 'sys_page_home';

$customized_home_id = $customizing->getCustomizingValue($home_Customizing_key);

$content = new content($customized_home_id ,$language_id);

$home_text = $content->getText($language_id);
$home_title = $content->getTitle($language_id);

echo '<h1>'. $home_title .'</h1>'. '<div class="boxwrapper">'.

		'<div class=" whitebox box_1inRow">
		<fieldset>
		<legend>
		<img ID="minilogo" src="images/logos/logo.png">
		</legend>'.
		$home_text.
		'</fieldset>
		</div>

		</div>';

?>

