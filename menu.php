<div class="mainmenu">
	<ul>
	   <li class="active"><a href="#!page=home&lang=<?php echo $site_language; ?>" id="home" class="nav"><span><?php echo VIEW_MENU_HOME; ?></span></a></li>
	   <li><a href="#!page=products&lang=<?php echo $site_language; ?>" id="products" class="nav"><span><?php echo VIEW_MENU_PRODUCTS; ?></span></a></li>
	   <li><a href="#!page=help&lang=<?php echo $site_language; ?>" class="lightbox"><span><?php echo VIEW_MENU_HELP; ?></span></a></li>
	   <li><a href="#!page=imprint&lang=<?php echo $site_language; ?>" id="imprint" class="nav"><span><?php echo VIEW_MENU_IMPRINT; ?></span></a></li>
	   
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