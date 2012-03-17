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
	<link href="css/public.css" rel="stylesheet">
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
		
		<ol class="locations">
			<?php foreach ($results as $location) : ?>
				<li itemscope itemtype="http://schema.org/TouristAttraction">
					<a href="single.php?id=<?php echo $location['id']; ?>" itemprop="name"><?php echo $location['name']; ?></a>
					<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
						<meta itemprop="latitude" content="<?php echo $location['latitude']; ?>">
						<meta itemprop="longitude" content="<?php echo $location['longitude']; ?>">
					</span>
				</li>
			<?php endforeach; ?>
		</ol>
		
		<div id="map"></div>
		
	</article>
	
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCkXYdCxOIr9-DwpF18ejWqV8C01jbmgxA&sensor=false"></script>
<script src="js/google-maps.js"></script>
