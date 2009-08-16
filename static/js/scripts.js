$(function() {
	
	/**
	*
	* Togglers for the tiny menu
	*
	*/
	
	$("#progressbar").click(function() {
	    $("#progress-todo-container").slideToggle();
	});
	
   // $("#information-toggle").click(function () {
   // 	$("#information").slideToggle();
   // });
	
    $("#information-toggle").toggle(function() {
      	$("#information").slideDown();
	},function () {
		$("#information").slideUp();
	});                               

    $("#add-note-toggle").click(function() {
	   $("#notes").hide(); 
	   $("#add-note").fadeIn(); 
	});

	$("#index-toggle").click(function() {
		$("#add-note").hide();
		$("#notes").fadeIn(); 
	});

	/**
	*
	* Deletes a note from the database upon clicking the "X" when hovering.
	*
	*/
	$('.delete-note').click(function() {
		var element = $(this);
		
		if(confirm("Are you sure you want to delete this post?")) {
			var noteId = element.attr("id");
			var data = 'action=deleteNote&id=' + noteId;
			// Find the parent div, the one with the same ID
			var parentz = $(".note[id=" + noteId + "]");
			$.ajax({
				type: "POST",
				url: "../../_ext/index/handler.php",
				data: data,
				success: function(){
					parentz.animate({ height: "0px", opacity: "0" }, function() {
						parentz.remove();
					});
				}
			});
		} else {
		}
	});


	/**
	* 
	* When hovering a note, show the option panel for that specific
	* note element.
	* 
	*/
	
	$('.note').hover(function() {
		var $kids = $(this).children();
      	var do_it = $kids.show();
	},function() {
		$('.options').hide();
	});
	
	/**
	* 
	* Set's the default width of the progress by looping through each
	* list item which is checked, and on each apply + 14 to the addi-
	* tional_progress variable which get's applies to the progressBar.
	* 
	*/
	
	function setDefaultProgressBar() {
		var current = 2;
		var additional_progress;
		
		$(".top li").each(function() {
			this_rel = $(this).attr('rel');
			
			if (this_rel === '1') {
				additional_progress = current += 14;
			}
		});
				
		// Set the new percent in the id (for new fetching)
		$(".progress-percent").attr("id", additional_progress);

	 	// Animate the bar to increase
		$(".progress-percent").animate({ width: additional_progress + '%' }, 'slow');
	}
	
	setDefaultProgressBar();
	
	/**
	*	
	* When the user clicks an item on the list, it'll add a tick (if there's none already)
	* however, if there's already a tick - it'll remove the old tick. You can't add a task
	* two tasks ahead, neither can you uncheck a task betwheen two tasks.
	*
	* It automaticly updates the progress bar when an item is checked/unchecked (animated).
	*
	*/
	
	$("#progress-todo-list li").live("click", function() {
		// Get's the ID of the item clicked, 1 = Item has a tick
	    proccess = $(this).attr('rel');
	    
	    // Item doesn't have a tick, add one
	    if (proccess === '0') {
	    	// Get the previous list item (1 = has a tick)
			prev = $(this).prev("li");
			// Get the id of this items (1 = has a tick)
			prev_id = prev.attr("rel");
			// Returns 1 if it's the first item in the list
			first = $(this).attr("id");
			// Checks if the previous task is complete,
			// Checks if it's the first item (then it wont have any previous tasks, and is allowed to be ticked)
			if (prev_id == '1' | first == '1') {
				// Append the tick to the item	
			    $(this).append(' <span class="green">✔</span>');
				
				$(this).attr('rel', '1');

				this_id = $(this).attr("id");

				$.ajax({
					type: "POST",
					url: "../../_ext/index/handler.php",
					data: "action=updateProgress&type=increase&id=" + this_id,
					success: function(){
						// Increase the width of the progressBar
						increaseProgressBar();
						// Set the id to one (ticked)
					}
				});
			} else {
				// There was no previous item which was ticked, and it wasn't the first item
				alert("Can't complete this task before previous is complete!");
			}
		// Item has a tick, remove it
	    } else {
	    	// Fetches the next list item
	    	next = $(this).next("li");
			// Fetches the id of that item (1 = has tick)
			next_id = next.attr("rel");
			// If the next item has a tick, don't allow the user to uncheck it
			if (next_id === '1') {
				alert("You can't uncheck a task betwheen done tasks");
			// Else it's safe to uncheck it
			} else {
				// Get the current content of the list item
			    var content = $(this).html();
			    // Split it where the span element starts (<span..)
			    var split = content.split(" <");
			    // Get the first part of the split (everything before span)
			    var new_content = split['0'];
				// Append this new HTML into the list
			    $(this).html(new_content);
				$(this).attr('rel', '0');

			    // Give the list element the id attribute 0 (doesn't have a tick)
				this_id = $(this).attr("id");

				$.ajax({
					type: "POST",
					url: "../../_ext/index/handler.php",
					data: "action=updateProgress&type=decrease&id=" + this_id,
					success: function(){
						decreaseProgressBar();
					}
				});
			}
	    }
	});
	
	/**
	* 
	* Decreases the width of the progress bar by 100 / 7 (rounded)
	* 
	*/
	
	function decreaseProgressBar() {
		// Get's the current % of the bar filled
	   	var currentProgress = parseInt($(".progress-percent").attr("id"));
	   	// Defines the local variable progress (the new progress)
		var progress;
	
		// If the current value is below 2 (reason for 2 is 100-(14*7) doesn't go to 0, but to 2), 
		// then don't minus it more (to not get a minus value)
		if (currentProgress < '3') {
			progress = currentProgress;
		// Else it's safe to minus
		} else {
			progress = currentProgress - 14;
		}
	    
	    // See above
	    $(".progress-percent").attr("id", progress);
	 	// Animate the bar to decrease
	    $(".progress-percent").animate({ width: progress + '%' }, 'slow');
	}
	
	/**
	* 
	* Increases the width of the progress bar by 100 / 7 (rounded)
	* 
	*/
	
  	function increaseProgressBar() {
		// See above
	    var currentProgress = parseInt($(".progress-percent").attr("id"));
	    var progress;
	    
	    // If the current progress is > 97 (reason is that 14*7 is 98, not 100) then don't modify it further.
	    // To avoid getting it be bigger than the wrapper
	    if (currentProgress > 97) {
	    	progress = currentProgress;
	    } else {
	    // Else it's safe to make it bigger
	    	progress = currentProgress += 14;
	    }
	    
	    // See above
	    $(".progress-percent").attr("id", progress);
	 	// Animate the bar to decrease
	    $(".progress-percent").animate({ width: progress + '%' }, 'slow');
	}
	
	/**
	* 
	* Updates the progress bar to the database.
	* 
	* @param string $type
	*/
	function updateProgressDatabase(type) {
		id = $(this).attr("id");

		if (type === 'increase') {
			$.ajax({
				type: "POST",
				url: "_../../ext/index/handler.php",
				data: "action=updateProgress&type=increase&id=" + id,
				success: function(){
				}
			});
		} else {
			$.ajax({
				type: "POST",
				url: "_../../ext/index/handler.php",
				data: "action=updateProgress&type=decrease&id=" + id,
				success: function(){
				}
			});
		}
	}

	var validator = $("#add-note-form").validate({
		rules: {
			post_title: {
				required: true
			},
			post_content: {
				required: true
			}
		},
		submitHandler: function() {
	   	    var title = $("#post_title").attr("value");
		    var content = $("#post_content").attr("value");
            var project_id = $("#add-note").attr("rel");
			var submit_button = $("#submit-add-note");
			
			$("#add-note").hide();

		    $.ajax({
            	type: "post",
		    	url: "../../_ext/index/handler.php",
		    	data: "action=addNote&project=" + project_id + "&title=" + title + "&content=" + content,
		    	success: function() {
					$("#notes").html("");
					$("#add-notes").attr("rel");
					$("#notes").load("../../_ext/index/notes.php", {id: project_id}, function() {
						$("#notes").fadeIn();
						// Empty the textbox fields
						$("#post_title").val("");
						$("#post_content").val("");
					});
		    	}
		    });
		}
	});      
});
