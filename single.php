<?php

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

require_once 'includes/db.php';
require_once 'includes/functions.php';

$sql = $db->prepare('
	SELECT id, name, street_address, longitude, latitude, rate_total,rate_count
	FROM locations
	WHERE id = :id
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

$results = $sql->fetch();

if (empty($results)) {
	header('Location: index.php');
	exit;
}

if ($results['rate_count'] > 0) {
$rating = round($results['rate_total'] / $results['rate_count']);
} else {
$rating = 0;
}

$cookie = get_rate_cookie();

require_once '/includes/top.php';

?>
<article>
		<h2><?php echo $results['name']; ?></h2>
		 <ul>
		 	<li><b>Average Rating:</b> <meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter></li>
			<li><b>Street Address:</b> <?php echo $results['street_address']; ?></p></li>
			<li><b>Longitude:</b> <?php echo $results['longitude']; ?></p></li>
			<li><b>Latitude:</b> <?php echo $results['longitude']; ?></p></li>
		</ul>
		
		<?php if (isset($cookie[$id])) : ?>

		<h2>Your rating</h2>
		<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
		<?php $class = ($i <= $cookie[$id]) ? 'is-rated' : ''; ?>
		<li class="rater-level <?php echo $class; ?>">❤</li>
		<?php endfor; ?>
		</ol>
		
		<?php else : ?>
		
		<h2>Rate</h2>
		<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
		<li class="rater-level"><a href="rate.php?id=<?php echo $results['id']; ?>&rate=<?php echo $i; ?>">❤</a></li>
		<?php endfor; ?>
		</ol>
		
		<?php endif; ?>
	 
    <div class="back"> <a href="index.php">Back</a> </div>
	
</article>
<?php require_once '/includes/bottom.php'; ?>