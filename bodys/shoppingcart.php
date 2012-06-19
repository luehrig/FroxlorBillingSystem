<?php 
		
$cart = new shoppingcart(session_id());

echo '	

<div class="boxwrapper">
	<div class=" whitebox box_1inRow">
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
				Warenkorb
			</legend>
			
			'.$cart->printCart().'
			
			
			
		</fieldset>
	</div>
	
	
</div>

';?>