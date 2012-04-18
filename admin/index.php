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
	ORDER BY name ASC
');

require_once '../includes/admin-header.php';

?>
	<section>
		<h2>Add a New Splash Pad</h2>
		<p class="section-description">Add a new splash pad to your existing list.</p>
		<ul>
			<li><a href="add.php">Add a Splash Pad</a></li>
		</ul>
	</section>
	
	<section>
		<h2>Manage Splash Pads</h2>
		<p class="section-description">Choose to edit or delete existing splash pads.</p>
		
		<ul>
			<?php foreach ($results as $location) : ?>
				<li>
					<p><a href="../single.php?id=<?php echo $location['id']; ?>"><?php echo $location['name']; ?></a></p>
					<p class="edit-delete"><a href="edit.php?id=<?php echo $location['id']; ?>">Edit</a> &middot; <a href="delete.php?id=<?php echo $location['id']; ?>">Delete</a></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

<?php require_once '../includes/admin-footer.php'; ?>