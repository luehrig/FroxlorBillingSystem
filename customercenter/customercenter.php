<?php 
		
$content = new content(1);
		
echo '

	<div class="content_container">
	
		
		<div class="customermenu">
			<ul>
			   <li class="active"><a href="#!mydata&lang='. language::getBrowserLanguage() .'" id="mydata" rel="'. $_SESSION['customer_id'] .'"><span>'. VIEW_CMENU_MYDATA .'</span></a></li>
			   <li><a href="#!myproducts&lang='. language::getBrowserLanguage() .'" id="myproducts"><span>'. VIEW_CMENU_MYPRODUCTS .'</span></a></li>
			   <li><a href="#!myinvoices&lang='. language::getBrowserLanguage() .'" id="myinvoices"><span>'. VIEW_CMENU_MYINVOICES .'</span></a></li>
			</ul>
		</div>
	
		<div class="customer_content_container">
			<!-- content depends on menu click -->
		</div>
	</div>';

?>