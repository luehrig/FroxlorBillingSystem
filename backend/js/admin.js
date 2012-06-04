// append to every textarea with class editor a CKEditor
function initCKEditor() {
	$( 'textarea.editor' ).ckeditor();
}

$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
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
	$('body').on("click","a[id=modify_customizing]", function() {
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
});