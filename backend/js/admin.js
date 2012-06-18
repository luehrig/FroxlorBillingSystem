// append to every textarea with class editor a CKEditor
function initCKEditor() {
	// if old instance exists destroy it!
	if(CKEDITOR.instances.text) {
		CKEDITOR.instances.text.destroy(true);	
	}
	
	$( 'textarea.editor' ).ckeditor();
}

$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});

	
	// process login procedure for shop backend
	$("body").on("click","form[id=loginformbackend] input[type=submit][id=login]", function() {
		var email = $('input[type=text][id=email]').val();
		var password = $('input[type=password][id=password]').val();
		
		// do ajax call. If login was successful redirect to customer center
		$.ajax({
			type: "POST",
			url: "../logic/process_usermanagement.php",
			data: { action: "login_backend", email: email, password: password }
		}).done(function( msg ) {
			$('#messagearea').html( msg );
			window.location.href = "../backend/index.php";
		});
		
		// reset input fields
		$('input[type=text][id=email]').val('');
		$('input[type=password][id=password]').val('');
		
		return false;
	});	
	
	
	// get overview page with all customizing entries
	$("body").on("click", "a[id=myshop]", function() {

		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_customizing_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
			$('a[id=save_customizing]').hide();
		});
		
		return false;
	});	
	
	// set customizing fields editable
	$('body').on("click","a[id=edit_customizing]", function() {
		// set all input fields as editable
		$('input[type=text]').each(function() {
			$(this).attr('readonly', false);
		});
		
		// hide link
		$(this).hide();
		// show save link
		$('a[id=save_customizing]').show();
	});	
	
	// set customizing fields editable
	$('body').on("click","a[id=save_customizing]", function() {
		// set all input fields as editable
		$('input[type=text]').each(function() {
			$(this).attr('readonly', true);
			
			var key = $(this).attr('id');
			var value = $(this).val();
			var language = $('input[type=hidden][id=language]').val();
			
			$.ajax({
				type: "POST",
				url: "logic/process_db.php",
				data: { action: "save_customizing_entry", key: key, value: value, language: language }
			}).done(function( msg ) {
				//$('.content').html( msg );
			});
			
		});
		
		// hide link
		$(this).hide();
		// show save link
		$('a[id=modify_customizing]').show();
	});	
	
	// get overview page with all products
	$("body").on("click", "a[id=myproducts]", function() {

		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_products_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// set customizing fields editable for products
	$('body').on("click","a[id=edit_product]", function() {
		var primaryKeysFromPhp = $(this).attr('rel');
		var primaryKeys = primaryKeysFromPhp.split(",");
		
		var product_id = primaryKeys[0];
		var language_id = primaryKeys[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_product_editor", product_id: product_id , language_id: language_id}
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
		
	});	
	
	// edit product
	$("body").on("click", "input[type=submit][id=submit_edit_product]", function() {
		
		var product_id = $('input[type=hidden][id=product_id]').val();
		var language_id = $('select[name=language_selection] option:selected').attr('id');
		var title = $('input[type=text][id=title]').val();
		var contract_periode = $('input[type=text][id=contract_periode]').val();
		var description = $('textarea[id=description]').val();
		var quantity = $('input[type=text][id=quantity]').val();
		var price = $('input[type=text][id=price]').val();
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "edit_product", product_id: product_id, language_id: language_id, title: title, contract_periode: contract_periode, description: description, quantity: quantity, price: price }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});
	
	// open translate Product form
	$("body").on("click","a[id=translate_product]", function() {
		var primaryKeysFromPhp = $(this).attr('rel');
		var primaryKeys = primaryKeysFromPhp.split(",");
		
		var product_id = primaryKeys[0];
		var language_id = primaryKeys[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_translate_product_form", product_id: product_id, language_id: language_id}
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});
	
	// translate product
	$("body").on("click", "input[type=submit][id=submit_translate_product]", function() {
		
		var product_id = $('input[type=hidden][id=product_id]').val();
		var language_id = $('select[name=language_selection] option:selected').attr('id');
		var title = $('input[type=text][id=title]').val();
		var contract_periode = $('input[type=text][id=contract_periode]').val();
		var description = $('textarea[id=description]').val();
		var quantity = $('input[type=text][id=quantity]').val();
		var price = $('input[type=text][id=price]').val();
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "translate_product", product_id: product_id, language_id: language_id, title: title, contract_periode: contract_periode, description: description, quantity: quantity, price: price }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});
	
	// change product-state
	$('body').on("click","a[id=change_product_state]", function() {
		var primaryKeysFromPhp = $(this).attr('rel');
		var primaryKeys = primaryKeysFromPhp.split(",");
		
		var product_id = primaryKeys[0];
		var language_id = primaryKeys[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "change_product_state", product_id: product_id, language_id: language_id }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
		
	});	
	
	// set customizing fields editable for creating a new product
	$('body').on("click","a[id=create_new_product]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_create_product_form"}
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
		
	});	
	
	// delete product
	$('body').on("click","a[id=delete_product]", function() {
		var primaryKeysFromPhp = $(this).attr('rel');
		var primaryKeys = primaryKeysFromPhp.split(",");
		
		var product_id = primaryKeys[0];
		var language_id = primaryKeys[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "delete_product", product_id: product_id, language_id: language_id }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
		
	});	
	
	
	// save product
	$("body").on("click", "input[type=submit][id=save_product]", function() {
		
		var language_id = $('select[name=language_selection] option:selected').attr('id');
		var title = $('input[type=text][id=title]').val();
		var contract_periode = $('input[type=text][id=contract_periode]').val();
		var description = $('textarea[id=description]').val();
		var quantity = $('input[type=text][id=quantity]').val();
		var price = $('input[type=text][id=price]').val();
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "create_new_product", language_id: language_id, title: title, contract_periode: contract_periode, description: description, quantity: quantity, price: price }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});
	
	// get overview page with all product attributes.
	$("body").on("click", "a[id=myproductattributes]", function() {

		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_product_attributes_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
//	// set customizing fields editable for product attributes
//	$("body").on("click", "a[id=edit_product_atrribute]", function() {
//		
//		$.ajax({
//			type: "POST",
//			url: "logic/process_action.php",
//			data: { action: "get_product_attributes_overview" }
//		}).done(function( msg ) {
//			$('.content').html( msg );
//		});
//		
//		return false;
//	});	

	
	// get overview page with all servers
	$("body").on("click", "a[id=myservers]", function() {

		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_server_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// get overview page with all customers
	$("body").on("click", "a[id=mycustomers]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_customers_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// set customizing fields editable for customer
	$('body').on("click","a[id=edit_customer]", function() {
		var customer_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_customer_editor", customer_id: customer_id }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
		
	});	
	
    // get overview page with all contents
	$("body").on("click", "a[id=mycontent]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_content_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// open editor for content
	$("body").on("click", "a[id=edit_content]", function() {

		var information = $(this).attr('rel');
		var stringParts = information.split('_');
		var content_id = stringParts[0];
		var language_id = stringParts[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_content_editor", content_id: content_id, language_id: language_id }
		}).done(function( msg ) {
			$('.content').html( msg );
			initCKEditor();
		});
		
		return false;
	});
	
	// delete content
	$("body").on("click", "a[id=delete_content]", function() {

		var information = $(this).attr('rel');
		var stringParts = information.split('_');
		var content_id = stringParts[0];
		var language_id = stringParts[1];
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "delete_content", content_id: content_id, language_id: language_id }
		}).done(function( msg ) {
			// reload content area
			$.ajax({
				type: "POST",
				url: "logic/process_action.php",
				data: { action: "get_content_overview" }
			}).done(function( msg ) {
				$('.content').html( msg );
			});
		});
		
		return false;
	});
	
	// open editor for new content
	$("body").on("click", "a[id=create_new_content]", function() {
	
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "open_new_content_editor" }
		}).done(function( msg ) {
			$('.content').html( msg );
			initCKEditor();
		});
		
		return false;
	});
	
	// open editor for content
	$("body").on("click", "input[type=submit][id=save_content]", function() {

		var content_id = $('input[type=hidden][id=content_id]').val();
		var language_id = $('input[type=hidden][id=language_id]').val();
		var title = $('input[type=text][id=title]').val();
		var text = $('textarea[id=text]').val();
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "update_content", content_id: content_id, language_id: language_id, title: title, text: text }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// open editor for content
	$("body").on("click", "input[type=submit][id=create_content]", function() {

		var title = $('input[type=text][id=title]').val();
		var text = $('textarea[id=text]').val();
		var language_id = $('select[name=language_selection] option:selected').attr('id');
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "create_content", language_id: language_id, title: title, text: text }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	 // get overview page with shop statistics
	$("body").on("click", "a[id=mystatistics]", function() {
		
		$.ajax({
			type: "POST",
			url: "logic/process_action.php",
			data: { action: "get_statistic_overview" }
		}).done(function( msg ) {
			$('.content').html( msg );
		});
		
		return false;
	});	
	
	// logout customer and redirect to main page
	$("body").on("click", "a[id=logout]", function() {
		
		$.ajax({
			type: "POST",
			url: "../logic/process_usermanagement.php",
			data: { action: "logout_backend" }
		}).done(function( msg ) {
			$('#messagearea').html( msg );
			window.location.href = "../index.php";
		});
		
		return false;
	});
	
	// alert message with
});

	
