$(function() {
	// Tests the database
	$("#test_database").click(function() {
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: "action=test&class=database",
			success: function(response) {
				$("#database_response").append(response).hide();	
				$("#database_response").slideDown();
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
				alert("Please check your database in order to confirm whetever the operation was sucessful or not");
			}
		});
	});
});
