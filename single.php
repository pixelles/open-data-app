<?php

require_once 'includes/filter-wrapper.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

// Only connect to the database if there is an ID, becuse this is after the above if-statement
// Without an ID there is no point connecting to the database
require_once 'includes/db.php';

// ->prepare() allows us to execute SQL with user input
$sql = $db->prepare('
	SELECT id, name, street_address, longitude, latitude
	FROM locations
	WHERE id = :id
');

// ->bindValue() lets us fill in placeholders in our prepared statement
// :id is a placeholder for us to SECURELY put information from the user
$sql->bindValue(':id', $id, PDO::PARAM_INT);

// Performs the SQL query on the database
$sql->execute();

// Gets the results from the SQL query and stores them in a variable
// ->fetch() gets a single result
// ->fetchAll() gets all the possible results
$results = $sql->fetch();

// Redirect the user back to the homepage if there are no database results
// No results will happen if they change the ?id=4 to include an ID that doesn't exist
if (empty($results)) {
	header('Location: index.php');
	exit; // Stop the PHP compiler right here and immediately redirect the user
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['name']; ?> &middot; Ottawa's Splendid Splash Pad Locator</title>
</head>
<body>
	<header>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="admin/index.php">Administration</a></li>
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
