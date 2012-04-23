<?php
/**
* Description: a file not seen by the user that process the user's inputted rating and pushes the information to the database.
*
* @package com.trishajessica.splashpadlocator
* @copyright 2012 Trisha Jessica
* @author Trisha Jessica <hello@trishajessica.ca>
* @link <http://www.pixelles.github.com/open-data-app>
* @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
* @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
*/

require_once 'includes/db.php';
require_once 'includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$rate = filter_input(INPUT_GET, 'rate', FILTER_SANITIZE_NUMBER_INT);
$cookie = get_rate_cookie();

if (empty($id)) {
	header('Location: index.php');
	exit;
}

if (isset($cookie[$id]) || $rate < 0 || $rate > 5) {
	header('Location: single.php?id=' . $id);
	exit;
}

$sql = $db->prepare('
	UPDATE locations
	SET rate_count = rate_count + 1, rate_total = rate_total + :rate
	WHERE id = :id
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);
$sql->bindValue(':rate', $rate, PDO::PARAM_INT);
$sql->execute();

save_rate_cookie($id, $rate);

header('Location: single.php?id=' . $id);
exit;