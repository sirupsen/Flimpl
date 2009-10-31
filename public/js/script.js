$(function() {
	// Tests the database
	$("#test_database").click(function() {
		$.ajax({
			type: "POST",
			url: "js/handler.php",
			data: "action=test&class=database",
			success: function(response) {
				$("#database_response").html(response).hide();	
				$("#database_response").fadeIn();
			}
		});
	});
});
