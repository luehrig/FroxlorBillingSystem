<?php 
		
$content = new content(2,$language_id);
		
echo '	

<h1>Startseite</h1>
<div class="boxwrapper">
	<div class=" whitebox box_1inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>Herzlich Willkommen</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>

	<div class="whitebox box_2inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>Info</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>
	<div class="whitebox box_2inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>Zusatz</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>

	<div class=" whitebox box_4inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>News</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>
	<div class="whitebox box_4inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>News</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>
	<div class="whitebox box_4inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>News</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>
	<div class="whitebox box_4inRow">
		<img ID="minilogo" src="images/logos/logo.png">
		<h3>News</h3>
		<div class="textbox">'. $content->getText() .'</div>
	</div>
</div>

';?>
	
