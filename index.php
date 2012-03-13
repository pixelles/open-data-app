<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

// `->exec()` allows us to perform SQL and NOT expect results(insert)
// `->query()` allows us to perform SQL and expect results(select)
$results = $db->query('
	SELECT id, name, street_address, longitude, latitude
	FROM locations
	ORDER BY street_address DESC
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>MTM1531: Project 01 - Open Data Application Prototype</title>
</head>
<body>
	<header>	
		<h1>Ottawa's Splendid Splash Pad Locator</h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="admin/index.php">Administration</a></li>
			</ul>
		</nav>
	</header>
	
	<article>
		<h2>Locations</h2>
		
		<ul>
			<?php foreach ($results as $location) : ?>
				<li><a href="single.php?id=<?php echo $location['id']; ?>"><?php echo $location['name']; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</article>
	
</body>
</html>
