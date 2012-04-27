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

if (empty($results)) {
	header('Location: index.php');
	exit;
}

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

				<ol class="rater single-page-rater">
				
					<?php for ($i = 1; $i <= 5; $i++) : ?>
					<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
						
						<li class="rater-level <?php echo $class; ?>">❤</li>
						
					<?php endfor; ?>
										
				</ol>
				
			<li class="single-section-details"><strong>Street Address:</strong> <?php echo $results['street_address']; ?></p></li>
			
			<li class="single-section-details"><strong>Longitude:</strong> <?php echo $results['longitude']; ?></p></li>
			
			<li class="single-section-details"><strong>Latitude:</strong> <?php echo $results['latitude']; ?></p></li>
		</ul>
	</section>
	
	<section class="single-section-transparent">
		
		<?php if (isset($cookie[$id])) : ?>

		<h2 class="rate-pointer">Your rating</h2>
			<ol class="rater rater-usable">
			<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $cookie[$id]) ? 'is-rated' : ''; ?>
				<li class="rater-level <?php echo $class; ?>">❤</li>
			<?php endfor; ?>
		</ol>
		
		<?php else : ?>
		
		<h2 class="rate-pointer">Rate This Pad</h2>
			<ol class="rater rater-usable">
				<?php for ($i = 1; $i <= 5; $i++) : ?>
			<li class="rater-level"><a href="rate.php?id=<?php echo $results['id']; ?>&rate=<?php echo $i; ?>">❤</a></li>
				<?php endfor; ?>
			</ol>
		
		<?php endif; ?>
	 
    <div class="back"> <a href="index.php">Back</a> </div>
	
</section>
<script type="text/javascript" src="http://trishajessica.disqus.com/combination_widget.js?num_items=5&hide_mods=0&color=blue&default_tab=people&excerpt_length=200"></script><a href="http://disqus.com/">Powered by Disqus</a>

<div id="disquis_thread" class="clearfix">

<script type="text/javascript">
/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
var disqus_shortname = 'trishajessica'; // required: replace example with your forum shortname
var disqus_developer = 0; // developer mode is on
/* * * DON'T EDIT BELOW THIS LINE * * */
(function() {
var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>

</div>

<?php if (sfConfig::get('sf_environment') == 'dev'): ?>
  var disqus_developer = 1;
<?php endif ?>

<?php require_once 'includes/footer.php'; ?>