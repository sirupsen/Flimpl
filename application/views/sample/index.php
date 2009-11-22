<p>This is a view file, following is a variable pushed from the controller:<br/>
<b><?php echo $variable;?></b></p>

<p>Here we have some data:</p>

<p><ul>
<?php foreach ($data as $name => $value) : ?>
	<li><b><?php echo ucfirst($name); ?></b>
		<ul>
			<li><i><?php echo $value; ?></i></li>
		</ul>
<?php endforeach; ?>
</ul></p>

<p>Let's check if it's valid data with some cool server-side validation! <br/>
Was the data valid? <b><?php echo ($validation) ? 'Yes' : 'No'; ?></b></p>
