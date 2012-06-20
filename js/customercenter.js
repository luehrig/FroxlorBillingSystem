$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});
	
	
	// Login: show customer header (welcome + logout link) and direct to customer center
	$("body").on("click", "input[id=ajaxlogin]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_content_handling.php",
			data: { action: "show_customercenter"}
		}).done(function( msg ) {
			$('.content_container').html( msg );
		});
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "show_customer_header"}
		}).done(function( msg ) {
			$('#customer_header').html( msg );
		});
		
		return false;
	});	

    // logout customer and redirect to main page
	$("body").on("click", "a[id=logout]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_usermanagement.php",
			data: { action: "logout_customer" }
		}).done(function( msg ) {
			$('#messagearea').html( msg );
			window.location.href = "index.php";
		});
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "remove_customer_header"}
		}).done(function( msg ) {
			$('#customer_header').html( msg );
		});
		
		return false;
	});	
	
<<<<<<< HEAD
=======
	
	// Handels customer menu click "My Data" --> get overview page with all customizing entries
	$("body").on("click", "a[id=mydata]", function() {

		var customer_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_customer_data", customer_id:customer_id }
		}).done(function( msg ) {
			$('.customer_content_container').html( msg );
			//$('a[id=save_customizing]').hide();
		});
		
		return false;
	});	
	
	// Handels button click "edit" --> get form with existing data as default
	$('body').on("click", "input[id=edit_customer]", function() {
		
		var customer_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_edit_customer_data", customer_id:customer_id }
		}).done(function( msg ) {
			$('.customer_content_container').html( msg );
			//$('a[id=save_customizing]').hide();
		});
		
		return false;
	});
	
	// Handels customer menu click "My Products" --> get overview page with customer's products
	$("body").on("click", "a[id=myproducts]", function() {

		var customer_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_customer_products", customer_id:customer_id }
		}).done(function( msg ) {
			$('.customer_content_container').html( msg );
			//$('a[id=save_customizing]').hide();
		});
		
		return false;
	});	
	
	// Handels customer menu click "My Invoices" --> get overview page with customer's invoices
	$("body").on("click", "a[id=myinvoices]", function() {

		var customer_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_customer_invoices", customer_id:customer_id }
		}).done(function( msg ) {
			$('.customer_content_container').html( msg );
			//$('a[id=save_customizing]').hide();
		});
		
		return false;
	});	
	
	
	
>>>>>>> branch 'master' of https://github.com/luehrig/FroxlorBillingSystem.git
});
