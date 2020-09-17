<?php 
$mapslistings = true;

	$mission = false;
	include 'header.php'; 

	$name = $_GET['name'];
	$id = $_GET['id'];
	$type = $_GET['type'];
	
	$lat = null;
	$long = null;
	
if($type == null){
	errormsg("Error");
	die();
}

$full = 'output-data/single.php?id=' . $id;
//$full = 'output-data/restaurant.php';

	?>

	<?php
	if(isset($name) && isset($id)){
		
		
						include 'config.php';
						include 'output-data/general.php';
					
						
						try {
							$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
							// set the PDO error mode to exception
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						}
						
						catch(PDOException $e)
						{
							echo "Connection failed: " . $e->getMessage();
						}
						
						$tablename = "markers";
						
						$stmt = $conn->query('SELECT * FROM  ' . $tablename . ' where type="' . $type . '" and marker_id="' . $id . '"');
						foreach ($stmt as $row)
						{
							 $name = $row['name'];
							 $lat = $row['lat'];
							 $long = $row['lng'];
							 $type = $row['type'];
							 $address = $row['address'];
							 $address = str_replace('"', '', $address);
							 
							 $marker_id = $row['marker_id'];
							 
							 $overall = prettyScore(getPct($marker_id, 'review_restaurant', 'overall'));
							 $parking = prettyScore(getPct($marker_id, 'review_restaurant', 'parking'));
							 $openButton = prettyScore(getPct($marker_id, 'review_restaurant', 'open_button'));
							 $tables = prettyScore(getPct($marker_id, 'review_restaurant', 'tables'));
							 $bathrooms = prettyScore(getPct($marker_id, 'review_restaurant', 'bathrooms'));
							
							?>
<div class="content-container establishment" style="margin: 100px auto; overflow: hidden; ">

		<h2><?php echo $name . " | " . ucfirst($type); ?></h2>
		<h3 style="margin-top: 0px; padding-top: 0px;"><?php echo $address ?></h3>
		<div class="estab-nav"><a href="new-review.php?type=<?php echo $type . "&id=" . $marker_id;?>">Write a Review</a> | <a href="">Directions</a></div>

		
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1w3MQvQMsQ_trICx5OyuyIzJbm8CUFPw&callback=initMap"></script>
		<div class="listing-divider">
			<?php
				
				echo "<div class=\"score-container\"><div id=\"score-title\">Overall:</div> " . $overall . "</div>";
				echo "<div class=\"score-container\"><div id=\"score-title\">Parking:</div> " . $parking . "</div>";
				echo "<div class=\"score-container\"><div id=\"score-title\">Entrance:</div> " . $openButton . "</div>";
				echo "<div class=\"score-container\"><div id=\"score-title\">Tables:</div> " . $tables . "</div>";
				echo "<div class=\"score-container\"><div id=\"score-title\">Bathrooms:</div> " . $bathrooms . "</div>";
				
			?>
		</div>
		<div class="listing-divider">
		<?php
		
			$map = true;
			if($map == true){
				echo "<div id=\"map\"></div>";

			}
			?>
		</div>
		<div class="reviews-container">
		
			<h2>All Reviews</h2>
		</div>
	
							
							<?php 
						
		getReviews('review_restaurant', $id);
							
							
						}
		
	}
	?>
	</div></div></div>
<?php
include 'footer.php'; 
?>

	    <script>
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 14, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}

    </script>
