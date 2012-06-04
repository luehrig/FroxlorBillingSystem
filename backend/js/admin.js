// append to every textarea with class editor a CKEditor
function initCKEditor() {
	$( 'textarea.editor' ).ckeditor();
}

$(function() {

	$(document).ready(function() {
		// code that is executed if page was loaded
		initCKEditor();
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