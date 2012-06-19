<?php 
		
$content = new content(1);
		
echo '
		
<h1>Produkte</h1>
<div class="boxwrapper">

	<!-- Product No.1 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="1">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book1" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="1">'. BUTTON_MORE .'</button>
	</div>
				
				
	<!-- Product No.2 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="2">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book2" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="2">'. BUTTON_MORE .'</button>
	</div>
				
	<!-- Product No.3 -->
	<div class="whitebox box_3inRow">
		<img ID="littlelogo" src="images/logos/logo.png">
		<fieldset>
			<legend>
				Produktname
			</legend>
			<p>'. $content->getText() .'</p>
		</fieldset>
		<button class="buttonlayout_buy" rel="3">'. BUTTON_ADD_TO_CART .'</button>
		<div id="book3" class="slidebox">
			<fieldset>'. $content->getText() .'</fieldset>
		</div>
<!-- TODO: rel tag has to content the product id! -->			
		<button class="buttonlayout_more" rel="3">'. BUTTON_MORE .'</button>
	</div>
				
</div>

';?>