$(function() {

	// SEO friendly URLS begin

	// Override the default behavior of all hyperlinks that are part of the nav
	// class so that, when
	// clicked, their `id` value is pushed onto the history hash instead of
	// being navigated to directly.
	$("body").on("click", "a[class=nav]", function() {
		var state = $(this).attr('id');
		var lang = $('input[type=hidden][id=site_language]').val();
		$.bbq.pushState('#!page=' + state + '&lang=' + lang);

		return false;
	});

	// Bind a callback that executes when document.location.hash changes.
	$(window).bind("hashchange", function(e) {
		var url = $.bbq.getState("!page");
		var lang = $.bbq.getState("lang");

		// dynamic content loading
		loadContent(url, lang);

	});

	// Since the event is only triggered when the hash changes, we need to
	// trigger the event now, to handle
	// the hash the page may have loaded with.
	$(window).trigger("hashchange");

	// SEO friendly URLS end

	$(document).ready(function() {
		// code that is executed if page was loaded

	});

	// check password length
	$("body").on("change", "form[id=registrationform] input[id=password]",
			function() {
				var password = $(this).val();

				$.ajax({
					type : "POST",
					url : "logic/process_inputcheck.php",
					data : {
						action : "check_password",
						password : password
					}
				}).done(function(msg) {
					$('#messagearea').html(msg);
				});
			});

	$("body")
			.on(
					"click",
					"form[id=registrationform] input[type=submit][id=register]",
					function() {
						var mandatory_filled = true;
						var customerData = {};

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
								$('#messagearea').html(msg);
							});
						} else {
							// get all input fields
							$('input[type=text]').each(function() {
								var key = $(this).attr('id');
								customerData[key] = $(this).val();
							});

							// get password
							customerData['password'] = $(
									'input[type=password][id=password]').val();

							// get all select fields
							$('select option:selected').each(function() {
								var key = $(this).attr('name');
								customerData[key] = $(this).attr('id');
							});

							$
									.ajax({
										type : "POST",
										url : "logic/process_db.php",
										data : {
											action : "create_customer",
											customerData : customerData
										}
									})
									.done(
											function(msg) {
												// $('#messagearea').html( msg
												// );
												window.location.href = "index.php#!page=customercenter";
											});
						}

						return false;
					});

	// process login procedure
	$("body")
			.on(
					"click",
					"form[id=loginform] input[type=submit][id=login]",
					function() {
						var email = $('input[type=text][id=email]').val();
						var password = $('input[type=password][id=password]')
								.val();

						// do ajax call. If login was successful redirect to
						// customer center
						$
								.ajax(
										{
											type : "POST",
											url : "../logic/process_usermanagement.php",
											data : {
												action : "login_customer",
												email : email,
												password : password
											}
										})
								.done(
										function(msg) {
											$('#messagearea').html(msg);
											window.location.href = "../customercenter/index.php?content=customercenter";
										});

						// reset input fields
						$('input[type=text][id=email]').val('');
						$('input[type=password][id=password]').val('');

						return false;
					});

	// process login procedure via ajax form
	/*
	 * $("body").on("click","form[id=loginform]
	 * input[type=submit][id=ajaxlogin]", function() { var email =
	 * $('input[type=text][id=email]').val(); var password =
	 * $('input[type=password][id=password]').val();
	 *  // do ajax call. If login was successful redirect to customer center
	 * $.ajax({ type: "POST", url: "logic/process_usermanagement.php", data: {
	 * action: "login_customer", email: email, password: password }
	 * }).done(function( msg ) { if(msg == 'true') { $.colorbox.close();
	 * $('a[id=customercenter]').addClass('nav'); } else {
	 * $('#messagearea').html( msg ); } });
	 *  // reset input fields $('input[type=text][id=email]').val('');
	 * $('input[type=password][id=password]').val('');
	 * 
	 * return false; });
	 */

	// open shopping cart -> obsolete since jquery bbq plugin
	// TODO: This is maybe a candidate for another colorbox
	/*
	 * $("body").on("click","a[id=shoppingcart]", function() { $.ajax({ type:
	 * "POST", url: "logic/process_content_handling.php", data: { action:
	 * "show_shoppingcart" } }).done(function( msg ) {
	 * $('.content_container').html( msg ); });
	 * 
	 * return false; });
	 */

	// remove product from shopping cart
	$("body").on("click", "a[id^=removeproduct_]", function() {
		var product_id = $(this).attr('rel');

		$.ajax({
			type : "POST",
			url : "logic/process_business_logic.php",
			data : {
				action : "remove_product_from_cart",
				product_id : product_id
			}
		}).done(function(msg) {
			setProductCountInCart();

			$.ajax({
				type : "POST",
				url : "logic/process_content_handling.php",
				data : {
					action : "show_shoppingcart"
				}
			}).done(function(msg) {
				$('.content_container').html(msg);
			});
		});

	});

	// first step in checkout process
	$("body").on("click", "a[id=start_checkout]", function() {
		$.ajax({
			type : "POST",
			url : "logic/process_usermanagement.php",
			data : {
				action : "isLoggedIn"
			}
		}).done(function(result) {
			// user is logged in as customer
			if (result == 'true') {

				$.ajax({
					type : "POST",
					url : "logic/process_content_handling.php",
					data : {
						action : "show_checkout_step2"
					}
				}).done(function(msg) {
					$('.content_container').html(msg);
				});
			}
			// user is not logged in as customer
			else {

				$.ajax({
					type : "POST",
					url : "logic/process_content_handling.php",
					data : {
						action : "show_checkout_step1"
					}
				}).done(function(msg) {
					$('.content_container').html(msg);
				});
			}
		});

		return false;
	});

	// third step in checkout process
	$("body").on("click", "input[id=check_terms]", function() {
		
		var navlink = $('a[id=checkout_step4]');
		
		if($(this).attr('checked') == 'undefined') {
			navlink.removeClass('nav');
			navlink.addClass('nonav');
		}
		else {
			navlink.removeClass('nonav');
			navlink.addClass('nav');
		}

		//return false;
	});
	
	
	// overlay for help menu
	$("body").on("click", "a[class=lightbox]", function() {
		$.colorbox({
			href : "help.php"
		});

		return false;
	});

	// start customer center or open colorbox with login form
	$("body").on("click", "a[id=customercenter]", function() {
		$.ajax({
			type : "POST",
			url : "logic/process_usermanagement.php",
			data : {
				action : "isLoggedIn"
			}
		}).done(function(result) {
			if (result != 'true') {
				$.colorbox({
					href : "logincustomer.php"
				});
			}
		});

		return false;

	});
	
	//closes the colorbox and opens registration.php
	$("body").on("click", "a[id=registration]", function() {
		var language = $(this).attr('rel');
		$.ajax({
			type : "POST",
			url : "logic/process_content_handling.php",
			data : {
				action : 'show_registration',
				language_id : language
				}
		}).done(function(msg) {
			$('.content_container').html(msg);
		});
		$.colorbox.close();

		return false;
	});
	

	// colorbox for customercenter
	$("body").on("click", "a[class=customercenter]", function() {
		// $.colorbox({href:"customercenter/index.php"});

		return false;
	});

	// display details for product in product overview
	$("body").on("click", "button[class=buttonlayout_more]", function() {
		// get product id from rel tag
		var product_id = $(this).attr('rel');

		var detailboxid = '#book' + product_id;

		if ($(detailboxid).is(":hidden")) {
			$(detailboxid).slideDown("slow");
		} else {
			$(detailboxid).slideUp();
		}
	});

	// add product from product overview to cart
	$("body").on("click", "button[class=buttonlayout_buy]", function() {
		// get product id from rel tag
		var product_id = $(this).attr('rel');

		$.ajax({
			type : "POST",
			url : "logic/process_business_logic.php",
			data : {
				action : "add_product_to_cart",
				product_id : product_id
			}
		}).done(function(msg) {
			setProductCountInCart();
		});

		return false;

	});
	
	$("body").on("click", "a[class=nav]", function(){
		
		$("a").removeClass("active");
		$(this).addClass("active");
	});

});

// update cart quantity
function setProductCountInCart() {
	// update shopping cart quantity
	$.ajax({
		type : "POST",
		url : "logic/process_business_logic.php",
		data : {
			action : "get_product_count_in_cart"
		}
	}).done(function(msg) {
		$('#current_cart_quantity').html(msg);
	});
}

// load specific content in content container
function loadContent(areacode, language_id) {
	var action = "show_" + areacode;

	$.ajax({
		type : "POST",
		url : "logic/process_content_handling.php",
		data : {
			action : action,
			language_id : language_id
		}
	}).done(function(msg) {
		$('.content_container').html(msg);
	});
}
