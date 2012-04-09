<?php

/**
 * Description: a small utility file to create an admin user. THIS FILE SHOULD NEVER BE PUBLICLY ACCESSIBLE
 *
 * @package com.trishajessica.splashpadlocator
 * @copyright 2012 Trisha Jessica
 * @author Trisha Jessica <hello@trishajessica.ca>
 * @link <http://www.pixelles.github.com/open-data-app>
 * @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
 * @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
 */
 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Create User</title>
</head>
<body>

<?php

require_once 'includes/db.php';
require_once 'includes/users.php';

$email = 'dupe0012@algonquinlive.com';
$password = 'password';

user_create($db, $email, $password);

?>
</body>
</html>