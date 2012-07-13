<?php 

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_content.php';
require_once PATH_CLASSES .'cl_customizing.php';

$language_id = language::ISOTointernal(language::getBrowserLanguage());

$customizing = new customizing($language_id);
$help_Customizing_key = 'sys_page_help';

$customized_help_id = $customizing->getCustomizingValue($help_Customizing_key);

$content = new content($customized_help_id ,$language_id);

$help_text = $content->getText($language_id);
$help_title = $content->getTitle($language_id);

echo '<h1>'. $help_title .'</h1>'. '<div class="boxwrapper">'.

		'<div class="left_text_align"><div class=" whitebox box_1inRow">
		<div class="help_style">
		<fieldset>'.
		$help_text.
		'</fieldset>
		</div>
		<fieldset>
		<h3>'. HEADING_SITEMAP .'</h3>
		<img src="'. PATH_IMAGES_REL .'sitemap_frontend.png" id="sitemap">
		</fieldset>
		
		</div></div>

		</div>';

?>







