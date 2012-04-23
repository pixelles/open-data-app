<?php

/**
* Description: allows the user to add a new splash pad location to the locator.
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

$errors = array();

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
$street_address = filter_input(INPUT_POST, 'street_address', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (empty($name)) {
$errors['name'] = true;
}

if (empty($longitude)) {
$errors['longitude'] = true;
}

if (empty($street_address)) {
$errors['street_address'] = true;
}

if (empty($errors)) {
require_once '../includes/db.php';

$sql = $db->prepare('
INSERT INTO locations (name, street_address, longitude, latitude)
VALUES (:name, :street_address, :longitude, :latitude)
');
$sql->bindValue(':name', $name, PDO::PARAM_STR);
$sql->bindValue(':street_address', $street_address, PDO::PARAM_STR);
$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
$sql->bindValue(':latitude', $latitude, PDO::PARAM_STR);
$sql->execute();

header('Location: index.php');
exit;
}
}

require_once '../includes/admin-header.php';

?>
<section class="form-section">
	<h2>Add a Location</h2>
		<p class="section-description">Add a new splash pad to your existing list using the form below:</p>
	
	<form method="post" action="add.php">
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
	<button type="submit">Add</button>
	</form>

</section>

<?php require_once '../includes/admin-footer.php'; ?>