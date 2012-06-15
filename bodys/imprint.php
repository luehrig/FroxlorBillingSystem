<?php
$content = new content(1); 
echo'
<h1>'.$content->getTitle() .'</h1>
	<div class="boxwrapper">
		<div class=" whitebox box_1inRow">
			<img ID="minilogo" src="images/logos/logo.png">
			<h3>'. $content->getTitle() .'</h3>
			<div class="textbox">'. $content->getText() .'</div>
		</div>
	</div>
</div>
'
?>