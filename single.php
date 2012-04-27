<?php

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

require_once 'includes/db.php';
require_once 'includes/functions.php';

$sql = $db->prepare('
	SELECT id, name, street_address, longitude, latitude, rate_total, rate_count
	FROM locations
	WHERE id = :id
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

$results = $sql->fetch();

//if (empty($results)) {
//	header('Location: index.php');
//	exit;
//}

$title = $results['name'];

if ($results['rate_count'] > 0) {
$rating = round($results['rate_total'] / $results['rate_count']);
} else {
$rating = 0;
}

$cookie = get_rate_cookie();

require_once 'includes/header.php';

?>
<section class="single-section">
		<h2><?php echo $results['name']; ?></h2>
		 <ul>
		 	<li><strong>Average Rating:</strong> 		
				<ol class="rater">
					<?php for ($i = 1; $i <= 5; $i++) : ?>
					<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
						
						<li class="rater-level <?php echo $class; ?>">❤</li>
							
					<?php endfor; ?>
				</ol>
				
			<li><strong>Street Address:</strong> <?php echo $results['street_address']; ?></p></li>
			
			<li><strong>Longitude:</strong> <?php echo $results['longitude']; ?></p></li>
			
			<li><strong>Latitude:</strong> <?php echo $results['latitude']; ?></p></li>
		</ul>
	</section>
	
	<section class="single-section-transparent">
		
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
	
</section>

<?php require_once '/includes/footer.php'; ?>