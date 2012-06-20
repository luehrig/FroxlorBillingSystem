<?php 

		
echo '	

<div class="colorboxwrapper">
	<form method="post" action="#" id="contact_message" accept-charset=utf-8>
		<fieldset>
			<legend>
				<img ID="minilogo" src="images/logos/logo.png">
				Kontakt
			</legend>
			<p>
				<label for="first_name">Vorname</label> 
				<input type="text" id="first_name" name="first_name" rel="mandatory">
			</p>
			<p>
				<label for="last_name">Nachname</label> 
				<input type="text" id="last_name" name="last_name" rel="mandatory">
			</p>
			<p>
				<label for="email">Email</label> 
				<input type="email" id="email" name="email" rel="mandatory">
			</p>
			<p>
	    		<input type="radio" name="message_type" value="Frage">Frage
	    		<input type="radio" name="message_type" value="Probleme">Probleme
	    		<input type="radio" name="message_type" value="Feedback">Feedback
	  		</p>
	  		<p>
	  			<label for="textfeld">Deine Nachricht</label><br>
				<textarea id="message" cols="30" rows="4"></textarea><br> 	
				<input type="submit" value="Senden" />
			</p>
		</fieldset>
	</form>
</div>

';?>






