$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});


	// check password length
	$("body").on("change", "input[id=password]", function() {
		var password = $(this).val();
		
		$.ajax({
			type: "POST",
			url: "logic/process_inputcheck.php",
			data: { action: "check_password", password: password }
		}).done(function( msg ) {
			$('#messagearea').html( msg );
		});	
	});

	$("body").on("click","input[type=submit][id=register]", function() {
		var mandatory_filled = true;
		var customerData = {};
		
		$("input[rel=mandatory]").each(function() {
			if(!$(this).val() && mandatory_filled == true) {
				mandatory_filled = false;
				return false;
			}
		});
		
		if(mandatory_filled == false) {
			$.ajax({
				type: "POST",
				url: "logic/process_inputcheck.php",
				data: { action: "get_message_mandatory_not_filled" }
			}).done(function( msg ) {
				$('#messagearea').html( msg );
			});	
		}
		else {
			// get all input fields
			$('input[type=text]').each(function() {
				var key = $(this).attr('id');
				customerData[ key ] = $(this).val();
			});
			
			// get password
			customerData['password'] = $('input[type=password][id=password]').val();
			
			// get all select fields
			$('select option:selected').each(function() {
				var key = $(this).attr('name');
				customerData[ key ] = $(this).attr('id');
			});
			
			$.ajax({
				type: "POST",
				url: "logic/process_db.php",
				data: { action: "create_customer", customerData: customerData }
			}).done(function( msg ) {
				$('#messagearea').html( msg );
			});
		}
		
		return false;
	});
	
});