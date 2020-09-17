<?php 

//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyCxPEA41SNQVoYL-AXRDMB6knxWd1LpKMY
$mapslistings = true;
include 'header.php';
$type = $_GET['type'];

$directory = 'output-xml/';
if($type == null){
	$type = "all";
}
else if($type == "restaurants"){
	$type = "restaurants";
}
else if($type == "shopping"){
	$type = "shopping";
}
else if($type == "grocery"){
	$type = "grocery";
}
else if($type == "leisure"){
	$type = "leisure";
}
else{
	$type = "all";
}

$full = "'" . $directory . $type . ".php'";


 ?>
	<div class="content-container">
		<h2>All Maps</h2>
		<div id="map"></div>


		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1w3MQvQMsQ_trICx5OyuyIzJbm8CUFPw&callback=initMap">
		</script>
		<div class="container-list">
			<a href="map.php?type=all"><div class="general-button green">All</div></a>
			<a href="map.php?type=restaurants"><div class="general-button green">Restaurants</div></a>
			<a href="map.php?type=shopping"><div class="general-button green">Shopping</div></a>
			<a href="map.php?type=grocery"><div class="general-button green">Grocery</div></a>
			<a href="map.php?type=hotels"><div class="general-button green">Hotels</div></a>
			<a href="map.php?type=leisure"><div class="general-button green">Leisure</div></a>
			<a href="search-new-review.php">
				<div class="general-button new-review">New Review</div>
			</a>
			<h2 id="title">Top Accessible Restaurants</h2>

					<?php 
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
						$stmt = $conn->query('SELECT * FROM  ' . $tablename . ' where type="restaurant"');
						foreach ($stmt as $row)
						{
							 $name = $row['name'];
							 $formatName = $row['format_name'];
							 $type = $row['type'];
							 $address = $row['address'];
							 $address = str_replace('"', '', $address);
							 
							 $marker_id = $row['marker_id'];
							 
							 $overall = getPct($marker_id, 'review_restaurant', 'overall');
							 $parking = getPct($marker_id, 'review_restaurant', 'parking');
							 $openButton = getPct($marker_id, 'review_restaurant', 'open_button');
							 $tables = getPct($marker_id, 'review_restaurant', 'tables');
							 $bathrooms = getPct($marker_id, 'review_restaurant', 'bathrooms');
							
							 
							 
							 echo "
								<div class=\"listing-container\">
									<div class=\"listing-divider\">
										<a href=\"establishment.php?name=$formatName&id=$marker_id&type=$type\"><img src=\"images/info.png\" id=\"info\">
										<h3 id=\"listing-title\">$name</h3></a><br/>
										
										
										<p id=\"address\"><a href=\"https://www.google.com/search?q=$name+$address\" target=\"_BLANK\">$address</a></p>
										<p><a href=\"\">Website</a> | <a href=\"\">Directions</a> | <a href=\"new-review.php?type=$type&id=$marker_id\">Write a Review</a>
									</div>
									<div class=\"listing-divider text-right\">
										 Overall: $overall <br/>
										 Parking: $parking <br/>
										 Open Button: $openButton<br/>
										 Tables: $tables<br/>
										 Bathrooms: $bathrooms<br/>
									</div>
								</div>
							 ";
						}
					?>
		
		
		</div>
	</div>
</div>
	
	
	
	    <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(43.81671385031048, -91.24170805358885),
          zoom: 15
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl(<?php echo $full; ?>, function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
			  var desc = '\n\n<br/><div style="color: red"> overall: ' + markerElem.getAttribute('overall');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address;
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent.outerHTML + desc);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>

	
<?php include 'footer.php';?>
	
