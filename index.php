<?php

require_once 'includes/db.php';

$results = $db->query('
	SELECT id, name, street_address, longitude, latitude, rate_total, rate_count
	FROM locations
	ORDER BY rate_total DESC
');

require_once 'includes/header.php';

?>
	<section>
		<button id="geo">Find my Location</button>
		<form id="geo-form">
			<label for="adr">Address</label>
			<input id="adr">
		</form>
	</section>
	
	<article>
	
		<h2>Locations</h2>
		
		<ol class="locations">
			<?php foreach ($results as $location) : ?>
			
			<?php
				if ($location['rate_count'] > 0) {
					$rating = round($location['rate_total'] / $location['rate_count']);
				} else {
					$rating = 0;
				}
			?>
				<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $location['id']; ?>">
				
				<strong class="distance"></strong>
				
					<a href="single.php?id=<?php echo $location['id']; ?>" itemprop="name"><?php echo $location['name']; ?></a>
					
					<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
						<meta itemprop="latitude" content="<?php echo $location['latitude']; ?>">
						<meta itemprop="longitude" content="<?php echo $location['longitude']; ?>">
					</span>
					
					<meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter>
					<ol class="rater">
					<?php for ($i = 1; $i <= 5; $i++) : ?>
						<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
						<li class="rater-level <?php echo $class; ?>">❤</li>
						<?php endfor; ?>
					</ol>
				</li>
				<?php endforeach; ?>
				</ol>
		
		<div id="map"></div>
		
	</article>

<?php require_once 'includes/footer.php'; ?>