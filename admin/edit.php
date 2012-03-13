<?php

require_once '../includes/filter-wrapper.php';
require_once '../includes/db.php';

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
if (empty($movie_title)) {
$errors['movie_title'] = true;
}

if (empty($release_date)) {
$errors['release_date'] = true;
}

if (empty($director)) {
$errors['director'] = true;
}

if (empty($errors)) {
$sql = $db->prepare('
UPDATE locations
SET name = :name, street_address = :street_address, longitude = :longitude, latitude = :latitude
WHERE id = :id
');
$sql->bindValue(':name', $name, PDO::PARAM_STR);
$sql->bindValue(':street_address', $street_addresse, PDO::PARAM_STR);
$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
$sql->bindValue(':longitude', $latitude, PDO::PARAM_STR);
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

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $name; ?> &middot; Edit Location</title>
</head>
<body>

<h1>Edit <?php echo $name; ?></h1>
<div class="delete">
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
</div>


    <div class="back"> <a href="index.php">Back</a> </div>
</body>
</html>