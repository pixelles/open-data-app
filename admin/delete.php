<?php

/**
 * Description: delets the selected splash pad location and then redirects immediately back to the administration page.
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
