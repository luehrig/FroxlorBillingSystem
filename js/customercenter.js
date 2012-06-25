$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});

	// Login: show customer header (welcome + logout link) and direct to
	// customer center
	$("body").on("click",
			"form[id=loginform] input[type=submit][id=ajaxlogin]", function() {

				var email = $('input[type=text][id=email]').val();
				var password = $('input[type=password][id=password]').val();

				// do ajax call. If login was successful redirect to customer
				// center
				$.ajax({
					type : "POST",
					url : "logic/process_usermanagement.php",
					data : {
						action : "login_customer",
						email : email,
						password : password
					}
				}).done(function(msg) {
					if (msg == 'true') {
						$.colorbox.close();
						$('a[id=customercenter]').addClass('nav');

						$.ajax({
							type : "POST",
							url : "logic/process_content_handling.php",
							data : {
								action : "show_customercenter"
							}
						}).done(function(msg) {
							$('.content_container').html(msg);
						});

						$.ajax({
							type : "POST",
							url : "logic/process_customer_action.php",
							data : {
								action : "show_customer_header"
							}
						}).done(function(msg) {
							$('#customer_header_ajax').html(msg);
						});

					} else {
						$('#messagearea').html(msg);
					}
				});

				// reset input fields
				$('input[type=text][id=email]').val('');
				$('input[type=password][id=password]').val('');

				return false;
			});

	// logout customer and redirect to main page
	$("body").on("click", "a[id=logout]", function() {

		$.ajax({
			type : "POST",
			url : "logic/process_usermanagement.php",
			data : {
				action : "logout_customer"
			}
		}).done(function(msg) {
			$('#messagearea').html(msg);
			window.location.href = "index.php";
		});

		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "remove_customer_header"
			}
		}).done(function(msg) {
			$('#customer_header').html(msg);
		});

		return false;
	});

	// Handels customer menu click "My Data" --> get overview page with all
	// customizing entries
	$("body").on("click", "a[id=mydata]", function() {

		var customer_id = $(this).attr('rel');

		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_data",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_content_container').html(msg);
			// $('a[id=save_customizing]').hide();
		});

		return false;
	});

	// Handels button click "edit" --> get form with existing data as default
	$('body').on("click", "input[id=edit_customer]", function() {

		var customer_id = $(this).attr('rel');

		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_edit_customer_data",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_content_container').html(msg);
		});

		return false;
	});

	// $('body').on("click", "input[id=same_adress]", function() {
	//		
	// $.ajax({
	// type: "POST",
	// url: "logic/process_customer_action.php",
	// data: { action: "hide_billingaddress"}
	// }).done(function( msg ) {
	// $('.billingaddress').html( msg );
	// });
	//		
	// return false;
	// });

	// Handels customer menu click "My Products" --> get overview page with
	// customer's products
	$("body").on("click", "a[id=myproducts]", function() {
		
		getCustomerProducts();

		return false;
	});

	// terminates contract
	$("body").on("click", "a[id=terminate_contract]", function() {

		var confirm_message = '';
		var contract_id = $(this).attr('rel');
		
		// get confirm message
		$.ajax({
			type : "POST",
			url : "logic/get_texts.php",
			data : {
				action : "get_message_delete_contract_confirm"
			}
		}).done(function(msg) {
			confirm_message = msg;
			
			var confirm_result = confirm( confirm_message );

			if (confirm_result == true) {
				
				$.ajax({
					type : "POST",
					url : "logic/process_business_logic.php",
					data : {
						action : "terminate_contract",
						contract_id : contract_id
					}
				}).done(function(msg) {
					
					getCustomerProducts();
					
				});
			}
			
		});
		
		

		return false;
	});

	// Handels customer menu click "My Invoices" --> get overview page with
	// customer's invoices
	$("body").on("click", "a[id=myinvoices]", function() {

		var customer_id = $(this).attr('rel');

		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_invoices",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_content_container').html(msg);
			// $('a[id=save_customizing]').hide();
		});

		return false;
	});

});

function getCustomerProducts() {
	
	$.ajax({
		type : "POST",
		url : "logic/process_customer_action.php",
		data : {
			action : "get_customer_products"
		}
	}).done(function(msg) {
		$('.customer_content_container').html(msg);
		// $('a[id=save_customizing]').hide();
	});
	
}