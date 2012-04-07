<?php

require_once '../includes/db.php';
require_once '../includes/users.php';

if (user_signed_in()) {
header('Location: index.php');
exit;
}

$errors = array();
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errors['email'] = true;
}

if (empty($password)) {
$errors['password'] = true;
}

if (empty($errors)) {
$user = user_get($db, $email);

if (empty($user)) {
$errors['email-non-existent'] = true;
} else {
if (passwords_match($password, $user['password'])) {
user_sign_in($user['id']);
header('Location: index.php');
exit;
} else {
$errors['password-no-match'] = true;
}
}
}
}

?><!DOCTYPE html>
<html lang="en-ca">
<head>
<meta charset="utf-8">
<title>Sign In · Dino Bone Finder</title>
</head>
<body>
<form method="post" action="sign-in.php">
<div>
<label for="email">E-mail Address</label>
<input type="email" id="email" name="email">
</div>
<div>
<label for="password">Password</label>
<input type="password" id="password" name="password">
</div>
<button type="submit">Sign In</button>
</form>
</body>
</html>