<?php

/**
 * Description: signs user out of the administration page.
 *
 * @package com.trishajessica.splashpadlocator
 * @copyright 2012 Trisha Jessica
 * @author Trisha Jessica <hello@trishajessica.ca>
 * @link <http://www.pixelles.github.com/open-data-app>
 * @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
 * @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
 */

require_once '../includes/users.php';

user_sign_out();

header('Location: sign-in.php');