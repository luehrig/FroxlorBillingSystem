<?php 

require_once PATH_CLASSES .'cl_language.php';
require_once PATH_CLASSES .'cl_customer.php';

require_once PATH_CLASSES .'cl_customizing.php';


$content = new content(2,$language_id);

echo '	
<h1>' .VIEW_MENU_HELP. '</h1>
<div class="boxwrapper">
	<div class=" whitebox box_1inRow">
		<fieldset>
			<legend>
				'. $content->getTitle() .'
			</legend>
				'. $content->getText() .'
		</fieldset>
	</div>
</div>
';

?>






