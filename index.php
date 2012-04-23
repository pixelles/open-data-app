<?php

require_once 'includes/db.php';

$results = $db->query('
	SELECT id, name, street_address, longitude, latitude, rate_total, rate_count
	FROM locations
	ORDER BY rate_total DESC
');

require_once 'includes/header.php';

?>

<section class="map-wrapper">

	<h2>Locator</h2>
	<div id="map"></div>
	
</section>

<section class="loc-wrapper">

	<h2 class="margin-h2">Splash Pads</h2>
	<div class="splash-pad-locations">
	
		<div>
			
			<form id="geo-form">
				<label for="adr">Address</label>
				<input id="adr" type="search" placeholder="Address or Postal Code">
				<button type="submit" id="search-button"></button>
			</form>
			
			<button id="geo-button"></button>
			
		</div>
	
		<div>

			<ol class="locations">
			
				<?php $count = 0; foreach ($results as $location) : ?>
				
				<?php
					if ($location['rate_count'] > 0) {
						$rating = round($location['rate_total'] / $location['rate_count']);
					} else {
						$rating = 0;
					}
				?>
				
				<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $location['id']; ?>" class="<?php if ($count < 5) { echo 'visible'; } ?> single-location">
					
					<a href="single.php?id=<?php echo $location['id']; ?>" itemprop="name"><strong class="distance"></strong> <?php echo $location['name']; ?></a>
						
					<meta itemprop="address" content="<?php echo $location['street_address']; ?>">
					
					<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
						<meta itemprop="latitude" content="<?php echo $location['latitude']; ?>">
						<meta itemprop="longitude" content="<?php echo $location['longitude']; ?>">
					</span>
					
					<meta itemprop="ratingCount" itemscope itemtype="http://schema.org/AggregateRating" content="<?php echo $location['rate_count']; ?>">
					<meta itemprop="ratingValue" itemscope itemtype="http://schema.org/AggregateRating" content="<?php echo $location['rate_total']; ?>">
			
					<ol class="rater">
					
						<?php for ($i = 1; $i <= 5; $i++) : ?>
						<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
						
							<li class="rater-level <?php echo $class; ?>">❤</li>
							
						<?php endfor; ?>
						
					</ol>
				</li>
				
				<?php $count++; endforeach; ?>
				
				</ol>
				
			</div>
		</div>
	</section>

<?php require_once 'includes/footer.php'; ?>