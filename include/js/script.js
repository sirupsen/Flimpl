$(function() {
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
	$("#create_errors").click(function() {
		var query = 'CREATE TABLE IF NOT EXISTS `errors` ( `id` int(11), `no` varchar(255), `message` text, `file` varchar(255), `line` varchar(255), `created` timestamp, `time` int(11), PRIMARY KEY (`id`))';
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: "action=query&class=database&query=" + query,
			success: function(response) {
				alert("Sucessfully created error table (this message also appears if it's already created)");
			}
		});
	});
});
