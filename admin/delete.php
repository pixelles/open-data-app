<?php

require_once '../includes/filter-wrapper.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

require_once '../includes/db.php';

$sql = $db->prepare('
	DELETE FROM locations
	WHERE id = :id
	LIMIT 1
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

header('Location: index.php');
exit;
