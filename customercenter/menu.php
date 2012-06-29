<?php 

?>
		
		echo '<div class="customermenu">
		<ul>
		<li class="cm_active"><a href="#!mydata&lang=<?php language::getBrowserLanguage(); ?>" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
		<li><a href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
		<li><a href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
		</ul>
		</div>';

			<div class="customer_content_container">
	 		/* content depends on menu click */
		</div>