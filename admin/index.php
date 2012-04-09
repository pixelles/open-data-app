<?php

/**
 * Description: user administration page to add, edit or delete splash pad locations.
 *
 * @package com.trishajessica.splashpadlocator
 * @copyright 2012 Trisha Jessica
 * @author Trisha Jessica <hello@trishajessica.ca>
 * @link <http://www.pixelles.github.com/open-data-app>
 * @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
 * @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
 */
 
require_once '../includes/users.php';
if (!user_is_signed_in()) {
	header('Location: sign-in.php');
	exit;
}

require_once '../includes/db.php';

$results = $db->query('
	SELECT id, name, street_address, longitude, latitude
	FROM locations
	ORDER BY street_address DESC
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Administration &middot; Ottawa's Splendid Splash Pad Locator</title>
</head>
<body>
	<header>	
		<h1>Ottawa's Splendid Splash Pad Locator</h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="index.php">Administration</a></li>
				<li><a href="sign-out.php">Sign Out</a></li>
				<li><a href="http://imm.edumedia.ca/dupe0012/open-data-app">Project Brief</a>
			</ul>
		</nav>
	</header>
	
	<article>
		<h2>Add a New Data Entry</h2>
		<p>Add a new location (data entry) to your database.</p>
		<ul>
			<li><a href="add.php">Add a data entry</a></p></li>
		</ul>
		
		<h2>Edit / Delete Data Entries</h2>
		<p>Manage your application's data entries using the management system below.</p>
		
		<ul>
			<?php foreach ($results as $location) : ?>
				<li><a href="../single.php?id=<?php echo $location['id']; ?>"><?php echo $location['name']; ?></a></li>
				&middot; <a href="edit.php?id=<?php echo $location['id']; ?>">Edit</a>
				&middot; <a href="delete.php?id=<?php echo $location['id']; ?>">Delete</a>
			<?php endforeach; ?>
		</ul>
	</article>
	
</body>
</html>
