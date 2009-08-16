<html>
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="static/css/style.css" type="text/css">
</head>

<body>
	<div id="wrapper">
		<div id="top">
			<h1>Flimpl</h1>
			<div class="indent">
				<h2>Framework, Simple</h2>
			</div>
		</div>

		<div id="content">
			<p>Welcome to the <span class="blue">Flimpl framework!</span> A simple framework made by <span class="green">Sirupsen</span>. This is the welcome file, it tells you that everything seems to be working correctly. To get started see the <span class="pink">README</span> file.</p>
			<ul>
				<li><h3>Some links..</h3>
					<ol class="super-indent">
						<?php foreach($links as $link) : ?>
						<li><a href="<?php echo $link[url]; ?>"><?php echo $link[name]; ?></a></li>
						<?php endforeach; ?>
					</ol>
				</li>
			</ul>


			<h1>Articles..</h1>
			<div class="indent">
				<?php foreach($articles as $article) : ?>
					<h2><?php echo $article[title]; ?></h2>
					<p><?php echo $article[text]; ?></p>
					<a><span class="blue"><?php echo $article[author] . '</span> - ' . $article[time]; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</body>
</html>
