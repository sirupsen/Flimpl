<p>This is a view file, here's a random number from the controller:
<!-- Variable passed to the template from the controller -->
<b><?php echo $number;?></b></p>

<p>Here we have some data:</p>

<p><ul>
<!-- For each data field in the array, write out the name and value -->
<?php foreach ($data as $name => $value) : ?>
	<li><b><?php echo ucfirst($name); ?></b>
		<ul>
			<li><i><?php echo $value; ?></i></li>
		</ul>
<?php endforeach; ?>
</ul></p>

<!-- If we return true, say yes - no if false -->
<p>Let's check if it's valid data with some cool server-side validation! <br/>
Was the data valid? <b><?php echo ($validation) ? 'Yes' : 'No'; ?></b></p>

<!-- Call some data directly from the model -->
<p>This data came from our model: <b> <?php echo $model->example(); ?> </b>

