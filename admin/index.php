<?php

require_once '../includes/db.php';
require_once '../includes/users.php';

if (!user_is_signed_in()) {
	header('Location: sign-in.php');
	exit;
}

$results = $db->query('
	SELECT id, name, street_address, longitude, latitude, rate_total
	FROM locations
	ORDER BY street_address DESC
');

require_once '../includes/admin-header.php';

?>
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

<?php require_once '../includes/admin-footer.php'; ?>