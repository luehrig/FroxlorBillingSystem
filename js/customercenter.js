$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});

	// Login: show customer header (welcome + logout link) and direct to
	// customer center
	$("body").on("click",
			"form[id=loginform] input[type=submit][id=ajaxlogin]", function() {

				var email = $('input[type=email][id=email]').val();
				var password = $('input[type=password][id=password]').val();
				var position = $('input[type=hidden][id=position]').val();

				// do ajax call. If login was successful redirect to last
				// position
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
						
						if (position != '') {
							$.ajax({
								type : "POST",
								url : "logic/process_content_handling.php",
								data : {
									action : "show_specific_page",
									destination : position
								}
							}).done(function(msg) {
								
							});
						} else {
							$.ajax({
								type : "POST",
								url : "logic/process_content_handling.php",
								data : {
									action : "show_customercenter"
								}
							}).done(function(msg) {
								$('.content_container').html(msg);
								$("a").removeClass("mm_active");
								$('a[id=customercenter]').addClass("mm_active");
							});
						}

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
						$.fn.colorbox.resize();
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

		// clear message area
		$('#error_msg_area').html('');
		$('.messagearea').html('');
		
		// get headline
		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_data_headline",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_headline_container').html(msg);
			// $('a[id=save_customizing]').hide();
		});
		
		// get content
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
	
	$("body").on("click", "a[id=back_to_customerdata]", function() {

		var customer_id = $(this).attr('rel');

		// clear message area
		$('#error_msg_area').html('');
		$('.messagearea').html('');
		
		// get headline
		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_data_headline",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_headline_container').html(msg);
			// $('a[id=save_customizing]').hide();
		});
		
		// get content
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

		// clear message area
		// $('#error_msg_area').html('');
		// $('.messagearea').html('');

		var customer_id = $(this).attr('rel');

		// get headline and "back"-link
		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_edit_customer_data_headline",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_headline_container').html(msg);
		});
		
		// get content
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

	// save changed customer data
	$('body').on("click",
			"form[class=edit_cust_data] img[id=save_customer]",

			// check if mandatory fields are filled
			function() {

				var mandatory_filled = true;
				var customerData = {};
				var shippingAddress = {};
				var billingAddress = {};

				$("input[rel=mandatory]").each(function() {
					if (!$(this).val() && mandatory_filled == true) {
						mandatory_filled = false;
						return false;
					}
				});
				if (mandatory_filled == false) {
					$.ajax({
						type : "POST",
						url : "logic/process_inputcheck.php",
						data : {
							action : "get_message_mandatory_not_filled"
						}
					}).done(function(msg) {
						$('#error_msg_area').html(msg);
						$('html, body').animate({
							scrollTop : $('.messagearea').offset().top
						}, 1000);

					});
				} else {
					// get all input fields for customer data
					$('input[id^=general]').each(function() {
						var key = $(this).attr('id');
						key = key.substr(7,key.strlen);
						
						customerData[key] = $(this).val();
					});
					
					// read shipping information
					var shipping_address_id = $('input[id=address_id_shipping]').val();
					
					$('input[id^=shipping]').each(function() {
						var key = $(this).attr('id');
						key = key.substr(8,key.strlen);
						
						shippingAddress[key] = $(this).val();
					});
					
					// read billing information
					var billing_address_id = $('input[id=address_id_billing]').val();
					
					$('input[id^=billing]').each(function() {
						var key = $(this).attr('id');
						key = key.substr(7,key.strlen);
						
						billingAddress[key] = $(this).val();
					});
					
					// get select fields
					$('select[id^=general] option:selected').each(function() {
						var key = $(this).attr('name');
						key = key.substr(7,key.strlen);
						
						customerData[key] = $(this).attr('id');
					});
					
					// get select fields
					$('select[id^=shipping] option:selected').each(function() {
						var key = $(this).attr('name');
						key = key.substr(8,key.strlen);
						
						shippingAddress[key] = $(this).attr('id');
					});
					
					// get select fields
					$('select[id^=billing] option:selected').each(function() {
						var key = $(this).attr('name');
						key = key.substr(7,key.strlen);
						
						billingAddress[key] = $(this).attr('id');
					});
					
					var customer_id = $(this).attr('rel');
					// update DB with changed customer data
					$.ajax({
						type : "POST",
						url : "logic/process_db.php",
						data : {
							action : "update_customer",
							customerData : customerData,
							customer_id : customer_id,
							shippingAddress : shippingAddress,
							shipping_address_id : shipping_address_id,
							billingAddress : billingAddress,
							billing_address_id : billing_address_id
						}
					}).done(function(msg) {
						$('.customer_content_container').html(msg);
					});

					// get overview page with all customizing entries
					// $.ajax({
					// type : "POST",
					// url : "logic/process_customer_action.php",
					// data : {
					// action : "get_customer_data",
					// customer_id : customer_id
					// }
					// }).done(function(msg) {
					// $('.customer_content_container').html(msg);
					// // $('a[id=save_customizing]').hide();
					// });
				}

				return false;
			});

	// Handels customer menu click "My Products" --> get overview page with
	// customer's products
	$("body").on("click", "a[id=myproducts]", function() {

		// clear message area
		$('#error_msg_area').html('');
		$('.messagearea').html('');

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

			var confirm_result = confirm(confirm_message);

			if (confirm_result == true) {

				$.ajax({
					type : "POST",
					url : "logic/process_business_logic.php",
					data : {
						action : "terminate_contract",
						contract_id : contract_id
					}
				}).done(function(msg) {

					$('.messagearea').html(msg);

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

		// clear message area
		$('#error_msg_area').html('');
		$('.messagearea').html('');
		
		// get headline
		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_invoices_headline",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_headline_container').html(msg);
		});

		// get content
		$.ajax({
			type : "POST",
			url : "logic/process_customer_action.php",
			data : {
				action : "get_customer_invoices",
				customer_id : customer_id
			}
		}).done(function(msg) {
			$('.customer_content_container').html(msg);
		});

		return false;
	});

});

function getCustomerProducts() {

	// get headline
	$.ajax({
		type : "POST",
		url : "logic/process_customer_action.php",
		data : {
			action : "get_customer_products_headline"
		}
	}).done(function(msg) {
		$('.customer_headline_container').html(msg);
	});
	
	// get content
	$.ajax({
		type : "POST",
		url : "logic/process_customer_action.php",
		data : {
			action : "get_customer_products"
		}
	}).done(function(msg) {
		$('.customer_content_container').html(msg);
	});

}