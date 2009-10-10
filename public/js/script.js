$(function() {
	// Tests the database
	$("#test_database").click(function() {
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: "action=test&class=database",
			success: function(response) {
				$("#database_response").html(response).hide();	
				$("#database_response").fadeIn();
			}
		});
	});
	// Creates the error table using direct access.
	// Notice: Can only do this when in debug mode. :)
	$("#create_errors").click(function() {
		var query = 'CREATE TABLE IF NOT EXISTS `errors` ( `id` int(11), `no` varchar(255), `message` text, `file` varchar(255), `line` varchar(255), `created` timestamp, `time` int(11), PRIMARY KEY (`id`))';
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: "action=query&class=database&query=" + query,
			success: function(response) {
				if (response === '1') {
					$("#error_logging").html("Query was <b>unsuccessful</b>. Please check your configuration, to confirm the database configured is created.").hide();	
					$("#error_logging").fadeIn();
				} else {
					$("#error_logging").html("Success! The error logging table was created successfully. Errors outside debugging mode will now be logged to that table.").hide();	
					$("#error_logging").fadeIn();
				}
			}
		});
	});
});
