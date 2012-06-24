<?php 
		
$cart = new shoppingcart(session_id());

?>

<h1><?php echo VIEW_MENU_SHOPPING_CART; ?></h1>
<div class="boxwrapper">
	<div class=" whitebox box_1inRow">
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
				Warenkorb
			</legend>
			
			<?php echo $cart->printCart(NULL, true); ?>
			
		</fieldset>
	</div>
	
	
</div>