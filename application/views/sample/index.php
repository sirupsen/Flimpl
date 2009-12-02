<p>This is a view file, here's a random number from the controller:
<b><?php echo $number;?></b></p>

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

<p>This data came from our model: <b> <?php echo $model->example(); ?> </b>

