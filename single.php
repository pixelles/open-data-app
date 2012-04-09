<?php

/**
 * Description: individual splash pad pages.
 *
 * @package com.trishajessica.splashpadlocator
 * @copyright 2012 Trisha Jessica
 * @author Trisha Jessica <hello@trishajessica.ca>
 * @link <http://www.pixelles.github.com/open-data-app>
 * @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
 * @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
 */
 
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

require_once 'includes/db.php';

$sql = $db->prepare('
	SELECT id, name, street_address, longitude, latitude
	FROM locations
	WHERE id = :id
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

$results = $sql->fetch();

if (empty($results)) {
	header('Location: index.php');
	exit;
}

?>

<!DOCTYPE HTML>
<html lang=en-ca>
<head>
	<meta charset=utf-8>
	<title><?php echo $results['name']; ?> &middot; Ottawa's Splendid Splash Pad Locator</title>
	<link href="css/public.css" rel="stylesheet">
	<script src="js/modernizr.dev.js"></script>
</head>
<body>

	<header>	
		<h1>Ottawa's Splendid Splash Pad Locator</h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="admin/index.php">Administration</a></li>
				<li><a href="http://imm.edumedia.ca/dupe0012/open-data-app">Project Brief</a>
			</ul>
		</nav>
	</header>
	
	<article>
		<h1><?php echo $results['name']; ?></h1>
		 <ul>
			<li><b>Street Address:</b> <?php echo $results['street_address']; ?></p></li>
			<li><b>Longitude:</b> <?php echo $results['longitude']; ?></p></li>
			<li><b>Latitude:</b> <?php echo $results['longitude']; ?></p></li>
		</ul>
	 </article>
	 
    <div class="back"> <a href="index.php">Back</a> </div>
	
</body>
</html>