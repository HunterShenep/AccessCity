<?php 
include 'session.php';
$forms = true;
$mission = false;
include 'header.php'; 

$bizName = $_POST['businessName'];
$address = $_POST['address'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];
$type = $_POST['type'];



$lat = $_POST['lat'];
$long = $_POST['long'];
$formatAddress = $_POST['formatAddress'];

$map_html = null;
$submit = "Submit";

?>
	<div class="content-container" style="margin: 100px auto;">
		<h2>New Business/Establishment</h2>
		<hr>
		

<?php
if((!$bizName == null) && (!$address == null)){
	//errormsg("Business & Address is set" . "</br></br>Biz name: $bizName </br> address: $address </br> City: $city </br> ZipCode: $zipcode </br>Type: $type </br> Lat: $lat </br> Long: </br> $long </br> $formatAddress</br>");
	
	if((!$address == null) && (!$city == null) && (!$zipcode == null)&& (!$type == null)){
		//All this is set, GOOD
		
		if((!$lat == null) && (!$long == null) && (!$formatAddress == null)){
			include 'config.php';
			
			$format_name = preg_replace("/[^a-zA-Z0-9  ]+/", "", $bizName);
			$tablename = "markers";
			$formatAddress = '"' . $formatAddress . '"';
			
			$stmt = $conn->prepare('INSERT INTO ' . $tablename . ' (marker_id, name, format_name, address, lat, lng, type) VALUES(NULL, :name, :format_name, :address, :lat, :lng, :type)');

				$stmt->bindValue(':name', $bizName);
				$stmt->bindValue(':format_name', $format_name);
				$stmt->bindValue(':address', $formatAddress);
				$stmt->bindValue(':lat', $lat);
				$stmt->bindValue(':lng', $long);
				$stmt->bindValue(':type', $type);
				$stmt->execute();
			
			successmsg("Success! Business has been created. Review it by <a href=\"search-new-review.php\">clicking here</a></div></div></div>");
			
			include 'footer.php';
			die();
		}
		else
		{
			include 'output-data/general.php';
			$concat = $address . ", " . $city . ", WI " . $zipcode;
			$array = geocode($concat);
			$lat = $array[0];
			$long = $array[1];
			$formatAddress = $array[2];
			
			$map_html = "<div id=\"map\"></div>";
			$submit = "I have confirmed everything";
			echo "<h2 id=\"alert\">Almost complete!</h2>";
			echo "<div id=\"alert\">Please verify the Pin on google map.</div>";
			echo "<div id=\"alert\">Please drag the location if it is not correct.</div>";
		}
		

		
	}
	else{
		errormsg("You forgot something! Please click Go back.");
		echo "</div></div></div>";
		include 'footer.php';
		die();
		
	}
}




?>

		
		<div class="new-business">
				<p>
					Use this form to add a new business, restaurant, bar etc to our 
					database for the use of others to find out about the accessibility there.
				</p>
				
				<p>
					Please note: This website and all establishments are limited to La Crosse and surrounding areas. Your submission may not 
					be instantly available to review.
				</p></br></br>
				
				
			<div class="half-divider newBiz">
			<?php 
				if($map_html == null){
					echo "<img src=\"images/map-preview.png\" style=\"width: 100%; height: 450px;\">";
				}
				else{
					echo $map_html;
				}
			?>
				
			</div>
			

			
			<form action="new-business.php" method="post">
			<div class="half-divider">
				Business/Establishment Name</br>
				<input type="text" name="businessName" class="input-text-long newBiz" value="<?php echo $bizName; ?>"><br/>
				
				Address<br/>
				<input type="text" name="address" class="input-text-long newBiz" value="<?php echo $address; ?>"><br/>
				
				City<br/>
				<select name="city" id="cars" class="input-text-long newBiz">
					<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
					<option value="La Crosse">La Crosse</option>
					<option value="Onalaska">Onalaska</option>
				</select><br/>
				
				
				
				Zipcode<br/>
				<select name="zipcode" id="cars" class="input-text-long newBiz">
					<option value="<?php echo $zipcode; ?>"><?php echo $zipcode; ?></option>
					<option value="54601">54601</option>
					<option value="54602">54602</option>
					<option value="54603">54603</option>
					<option value="54650">54650</option>
				</select><br/>
				
				Type of Establishment<br/>
				
				<select name="type" id="cars" class="input-text-long newBiz">
					<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
					<option value="restaurant">Restaurant</option>
					<option value="shopping">Shopping</option>
					<option value="grocery">Grocery</option>
					<option value="leisure">Leisure</option>
					<option value="hotel">Hotel</option>
				</select>
				<input type="hidden" id="orig" name="lat" value="">
				<input type="hidden" id="lat" name="lat" value="<?php echo $lat; ?>">
				<input type="hidden" id="long" name="long" value="<?php echo $long; ?>">
				<input type="hidden" name="formatAddress" value="<?php echo $formatAddress; ?>">
				
				
				<input type="submit" value="<?php echo $submit; ?>" class="general-button submit">
			</form>
			</div>
		</div>
		
		
		
	</div>
	
	
<script>
	
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?php echo $lat;?>, lng: <?php echo $long;?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 15, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map, draggable: true});
  
  
    marker.addListener('drag', function() {
		document.getElementById("orig").value = marker.position;
		formatt(marker.position);
  });

  
  
  
}

var lat = 1;

function formatt(orig){
	var newSt = orig.toString();
	newSt = newSt.replace(")", "");
	newSt = newSt.replace("(", "");
	newSt = newSt.replace(" ", "");
	var arrayy = newSt.split(",");
	
	
	document.getElementById("lat").value = arrayy[0];
	document.getElementById("long").value = arrayy[1];
}

function clearr(){
	document.getElementById("lat").value = "";
	document.getElementById("long").value = "";
}

    </script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1w3MQvQMsQ_trICx5OyuyIzJbm8CUFPw&callback=initMap">
    </script>
<?php include 'footer.php'; ?>