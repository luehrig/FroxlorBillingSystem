<?php 

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_customer.php';

require_once PATH_CLASSES .'cl_customizing.php';

$content_id_for_help = 3;
$language_id = language::ISOTointernal(language::getBrowserLanguage());
$content = new content($content_id_for_help ,$language_id);



echo '	
<h1>' .VIEW_MENU_HELP. '</h1>
<div class="boxwrapper">
	<div class=" whitebox box_1inRow">
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
			</legend>
				'. $content->getText() .'
		</fieldset>
	</div>
</div>
';

?>






