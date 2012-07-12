<?php
if(!isset($_GET['page'])) {
	include_once '../configuration.inc.php';
}

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customizing.php';

$language_id = language::ISOTointernal(language::getBrowserLanguage());

$customizing = new customizing($language_id);
$imprint_Customizing_key = 'sys_page_imprint';

$customized_imprint_id = $customizing->getCustomizingValue($imprint_Customizing_key);

$content = new content($customized_imprint_id ,$language_id); 

$imprint_text = $content->getText($language_id);
$imprint_title = $content->getTitle($language_id);

echo '<h1>'. $imprint_title .'</h1>'. '<div class="boxwrapper">'.

	'<div class=" whitebox box_1inRow">
	<div class="left_text_align">
		<fieldset>'.
			$imprint_text. 
		'</fieldset>
	</div>
	</div>
	
</div>';

?>
