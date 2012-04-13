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

// A small utility file for us to create an admin user
// THIS FILE SHOULD NEVER BE PUBLICLY ACCESSIBLE
$email = 'bradlet@algonquincollege.com';
$password = 'password';

user_create($db, $email, $password);

?>
</body>
</html>