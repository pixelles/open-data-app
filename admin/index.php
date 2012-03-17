<?php

require_once '../includes/filter-wrapper.php';
require_once '../includes/db.php';

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
	<title>Administration</title>
</head>
<body>
	<header>	
		<h1>Ottawa's Splendid Splash Pad Locator</h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="admin/index.php">Administration</a></li>
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
				&bull; <a href="edit.php?id=<?php echo $location['id']; ?>">Edit</a>
				&bull; <a href="delete.php?id=<?php echo $location['id']; ?>">Delete</a>
			<?php endforeach; ?>
		</ul>
	</article>
	
</body>
</html>
