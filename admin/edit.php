<?php

/**
* Description: allows the user to edit an already existing splash pad location.
*
* @package com.trishajessica.splashpadlocator
* @copyright 2012 Trisha Jessica
* @author Trisha Jessica <hello@trishajessica.ca>
* @link <http://www.pixelles.github.com/open-data-app>
* @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
* @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
*/

require_once '../includes/db.php';
require_once '../includes/users.php';

if (!user_is_signed_in()) {
	header('Location: sign-in.php');
	exit;
}

$errors = array();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$street_address = filter_input(INPUT_POST, 'street_address', FILTER_SANITIZE_STRING);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (empty($name)) {
	$errors['name'] = true;
}

if (empty($street_address)) {
	$errors['street_address'] = true;
}

if (empty($longitude)) {
	$errors['longitude'] = true;
}

if (empty($latitude)) {
	$errors['latitude'] = true;
}

if (empty($errors)) {
	$sql = $db->prepare('
	UPDATE locations
	SET name = :name, street_address = :street_address, longitude = :longitude, latitude = :latitude
	WHERE id = :id
	');
	
	$sql->bindValue(':name', $name, PDO::PARAM_STR);
	$sql->bindValue(':street_address', $street_address, PDO::PARAM_STR);
	$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
	$sql->bindValue(':latitude', $latitude, PDO::PARAM_STR);
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	$sql->execute();
	
	header('Location: index.php');
	exit;
}
} else {
$sql = $db->prepare('
	SELECT id, name, street_address, longitude, latitude
	FROM locations
	WHERE id = :id
	');

	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	$sql->execute();
	$results = $sql->fetch();
	
	$name = $results['name'];
	$street_address = $results['street_address'];
	$longitude = $results['longitude'];
	$latitude = $results['latitude'];
}

require_once '../includes/admin-header.php';

?>

<section class="form-section">

	<h2>Edit <?php echo $name; ?></h2>
	<p class="section-description">Edit this existing splash pad using the form below:</p>

	<form method="post" action="edit.php?id=<?php echo $id; ?>">
		<div>
			<label for="name">Location Name<?php if (isset($errors['name'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="name" name="name" value="<?php echo $name; ?>" required>
		</div>
		<div>
			<label for="street_address">Street Address<?php if (isset($errors['street_address'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="street_address" name="street_address" value="<?php echo $street_address; ?>" required>
		</div>
		<div>
			<label for="longitude">Longitude<?php if (isset($errors['longitude'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="longitude" name="longitude" value="<?php echo $longitude; ?>" required>
		</div>
		<div>
			<label for="latitude">Latitude<?php if (isset($errors['latitude'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="latitude" name="latitude" value="<?php echo $latitude; ?>" required>
		</div>
		<button type="submit">Save</button>
	</form>
	
</section>
	
<?php require_once '../includes/admin-footer.php'; ?>