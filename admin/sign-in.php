<?php 

/**
* Description: sign-in page featuring a form for the user to sign-in before viewing the administration page. If user is already signed in, they will be redirected to the administration page.
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

if (user_is_signed_in()) {
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
	
	if  (empty($errors)) {
		$user = user_get($db, $email);

		if (!empty($user)) {
			
			if (passwords_match($password, $user['password'])) {
				user_sign_in($user['id']);
				header('Location: index.php');
				exit;
			} else {
				$errors['password-no-match'] = true;
			}
			
		} else {
			$error['user-non-existent'] = true;
		}
	}
}

require_once '../includes/admin-header.php';

?>
<section class="form-section">
		<h2>Sign in</h2>
		<p class="section-description">You need to sign in to view the administration page.</p>

		<form method="post" action="sign-in.php">
			<div>
				<label for="email">E-mail Address <?php if (isset($errors['email'])) : ?> <strong>is required</strong><?php endif; ?><?php if (isset($errors['user-non-existent'])) : ?> <strong>This user does not exist</strong><?php endif; ?></label>
				<input type="email" id="email" name="email" required>
			</div>
			<div>
				<label for="password">Password <?php if (isset($errors['password'])) : ?> <strong>is required</strong><?php endif; ?><?php if (isset($errors['password-no-match'])) : ?> <strong>Passwords don't match</strong><?php endif; ?></label>
				<input type="password" id="password" name="password" required>
			</div>
			<button type="submit">Sign Me In</button>
		</form>

</section>

<?php require_once '../includes/admin-footer.php'; ?>