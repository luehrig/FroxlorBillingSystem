$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
	});

    // logout customer and redirect to main page
	$("body").on("click", "a[id=logout]", function() {
		
		$.ajax({
			type: "POST",
			url: "../logic/process_usermanagement.php",
			data: { action: "logout_customer" }
		}).done(function( msg ) {
			$('#messagearea').html( msg );
			window.location.href = "../index.php";
		});
		
		return false;
	});	
	
});