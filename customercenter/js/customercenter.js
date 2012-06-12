$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});

	
	// get overview page with all customizing entries
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
	
});