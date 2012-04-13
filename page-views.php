<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Page Views</title>
</head>
<body>
<?php

// Track how many times you've viewed this page for this session

// Turn on sessions
session_start();

$_SESSION['page-view'] += 1;

?>

<strong>You've visited this page <?php echo $_SESSION['page-view']; ?> times.</strong>
</body>
</html>