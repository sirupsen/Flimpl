<?php
// Makes a function which can be used to handle exceptions
function exception_handler($exception) { ?>
	<div class="error">
		<?php echo $exception->getMessage(); ?>
	</div>
<?php
}
