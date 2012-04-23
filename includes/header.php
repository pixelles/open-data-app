<?php
/**
* Description: a file containing all the repetitive layout codes for the top half of a page.
*
* @package com.trishajessica.splashpadlocator
* @copyright 2012 Trisha Jessica
* @author Trisha Jessica <hello@trishajessica.ca>
* @link <http://www.pixelles.github.com/open-data-app>
* @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
* @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
*/
?><!DOCTYPE HTML>
<html lang=en-ca>
<head>
	<meta charset=utf-8>
	<title><?php if (isset($title)) { echo $title . ' · '; } ?>Ottawa's Splendid Splash Pad Locator</title>
	<link href="css/public.css" rel="stylesheet">
	<script src="js/modernizr.dev.js"></script>
</head>
<body>

	<header>	
		<h1>Ottawa's Splendid Splash Pad Locator</h1>
		<?php
			require 'users.php';
			if (user_is_signed_in()) :
		?>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="index.php">Home</a></li> &middot; 
				<li><a href="admin/index.php">Administration</a></li> &middot; 
				<li><a href="sign-out.php">Sign Out</a></li> &middot; 
				<li><a href="http://imm.edumedia.ca/dupe0012/open-data-app">Project Brief</a>
			</ul>
		</nav>
		<?php endif; ?>
	</header>
	
	<article>