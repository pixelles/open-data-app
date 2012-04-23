<?php
/**
* Description: a file containing functions to store cookies when users rate a splash pad location to avoid duplicate ratings.
*
* @package com.trishajessica.splashpadlocator
* @copyright 2012 Trisha Jessica
* @author Trisha Jessica <hello@trishajessica.ca>
* @link <http://www.pixelles.github.com/open-data-app>
* @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
* @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
*/

function save_rate_cookie ($id, $rate) {
	$cookie = get_rate_cookie();

	$rated = array();

	foreach ($cookie as $key=>$value) {
		$rated[] = $key . ':' . $value;
	}

	$rated[] = $id . ':' . $rate;
	$cookie_content = implode(';', $rated);

	setcookie('locations_rated', $cookie_content, time() + 60 * 60 * 24 * 365, '/');
}

function get_rate_cookie () {
	$cookie_content = filter_input(INPUT_COOKIE, 'locations_rated', FILTER_SANITIZE_STRING);

	if (empty($cookie_content)) {
		return array();
	}

	$rated = explode(';', $cookie_content);

	$ratings = array();

	foreach ($rated as $item) {
		$pieces = explode(':', $item);
		$ratings[$pieces[0]] = $pieces[1];
	}

	return $ratings;
}
