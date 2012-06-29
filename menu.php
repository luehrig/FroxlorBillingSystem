<div class="mainmenu">
	<ul>
	   <li><a href="home.html?lang=<?php echo $site_language; ?>" id="home" class="nav mm_active"><span><?php echo VIEW_MENU_HOME; ?></span></a></li>
	   <li><a href="products.html?lang=<?php echo $site_language; ?>" id="products" class="nav"><span><?php echo VIEW_MENU_PRODUCTS; ?></span></a></li>
	   
	   <!-- menu link for contact form if javascript is active (form will be opened in a popup) -->
	   <div id="contact_form_js"></div>
		<script type="text/javascript">
			document.getElementById("contact_form_js").innerHTML='<li><a href="content_js.html?lang=<?php echo $site_language; ?>" class="lightbox"><span><?php echo VIEW_MENU_CONTACT; ?></span></a></li>';
		</script>
		
		<!-- menu link for contact form if javascript is not active -->
	   <li><noscript><a href="contact.html?lang=<?php echo $site_language; ?>" id="contact" class="nav"><span><?php echo VIEW_MENU_CONTACT; ?></span></a></noscript></li>
	   
	   <li><a href="help.html?lang=<?php echo $site_language; ?>" id="help" class="nav"><span><?php echo VIEW_MENU_HELP; ?></span></a></li>
	   <li><a href="imprint.html?lang=<?php echo $site_language; ?>" id="imprint" class="nav"><span><?php echo VIEW_MENU_IMPRINT; ?></span></a></li>
	   
	   
	   <?php 
	    /*
	     * decide if customer is logged in or not
	     * if customer is logged in add "nav" class to customer center link
	     */
	   	if (customer::isLoggedIn(session_id()) == true ) {
	   		echo '<li id="mainmenuelement"><a href="#!page=customercenter&lang='. $site_language .'" id="customercenter" class="nav"><span>'. VIEW_MENU_CUSTOMERCENTER .'</span></a></li>';
	   	}
	   	else {
	   		echo '<li id="mainmenuelement"><a href="#!page=customercenter&lang='. $site_language .'" id="customercenter"><span>'. VIEW_MENU_CUSTOMERCENTER .'</span></a></li>';
	   	}
	   ?>
	   
	</ul>
</div>
