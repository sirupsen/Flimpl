<?php
/*
 *
 * A sample file on how to work with the templating
 * system.
 *
 */
?>

Hello <?php echo $name; ?><br/>
From TestClass: <br/>

<?php foreach($names as $person) : ?>
	<b><?php echo $person['name']; ?></b>
<?php endforeach; ?>
<br/><br/>

Here's a few rather fucked up names from the database..<br/><br/>

<?php foreach($fucked as $fuck) : ?>
	<b><?php echo $fuck['name']; ?></b><br/>
	Age: <?php echo $fuck['age']; ?><br/>
<?php endforeach; ?>

<?php foreach($articles as $article) : ?>
	<h1><?php echo $article['title']; ?></h1>
	<p><?php echo $article['content']; ?></p>
<?php endforeach; ?>
