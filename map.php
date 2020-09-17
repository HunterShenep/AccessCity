<?php 

//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyCxPEA41SNQVoYL-AXRDMB6knxWd1LpKMY
$mapslistings = true;
$forms = true;
include 'header.php';
$type = $_GET['type'];
$mtype = null;
$joinTable = null;

$directory = 'output-data/';
if($type == null){
	$mtype = "all";
}
else if($type == "restaurants"){
	$mtype = "restaurant";
	$joinTable = "review_restaurant";
}
else if($type == "shopping"){
	$mtype = "shopping";
	$joinTable = "review_shopping";
}
else if($type == "grocery"){
	$mtype = "grocery";
	$joinTable = "review_grocery";
}
else if($type == "leisure"){
	$mtype = "leisure";
	$joinTable = "review_leisure";
}
else if($type == "hotels"){
	$mtype = "hotel";
	$joinTable = "review_hotel";
}
else if($type == "all"){
	$mtype = "all";
}
else{
	$mtype = "all";
}

$full = "'" . $directory . $mtype . ".php'";


 ?>
	<div class="content-container">
		<h2 id="mtitle">La Crosse Accessible Establishments</h2>
		<?php
		
			$map = true;
			if($map == true){
				echo "<div id=\"map\"></div>";
			}
		//

		?>


		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1w3MQvQMsQ_trICx5OyuyIzJbm8CUFPw&callback=initMap">
		</script>
		<div class="container-list">
			<a href="map.php?type=all#mtitle"><div class="general-button green">All</div></a>
			<a href="map.php?type=restaurants#mtitle"><div class="general-button green">Restaurants</div></a>
			<a href="map.php?type=shopping#mtitle"><div class="general-button green">Shopping</div></a>
			<a href="map.php?type=grocery#mtitle"><div class="general-button green">Grocery</div></a>
			<a href="map.php?type=hotels#mtitle"><div class="general-button green">Hotels</div></a>
			<a href="map.php?type=leisure#mtitle"><div class="general-button green">Leisure</div></a>
			<a href="search-new-review.php"><div class="general-button new-review">New Review</div>
			</a>
			<div class="search-container">
				<div class="search-divider">
					<p>Our map pages consist of a map and listings of businesses. The map consists of labels for their categories above (e.g. R = Restaurant). 
					The business listings below are ordered by overall ratings. 
					</p>
				</div>
				<div class="search-divider right"><br/>
				Search for an establishment<br/>
					<input type="text" name="search" class="input-text-long"><input type="submit" class="input-search" value="Search">
				</div>
			</div>
				
					<?php 
						include 'config.php';
						include 'output-data/general.php';
						if($mtype !== "all"){
							getListings($type, $mtype, $joinTable, 0, 10);

						}
						else{
							getListings("restaurants", "restaurant", "review_restaurant", 0, 3);
							getListings("shopping", "shopping", "review_shopping", 0, 3);
							getListings("grocery", "grocery", "review_grocery", 0, 3);
							getListings("hotels", "hotel", "review_hotel", 0, 3);
							getListings("leisure", "leisure", "review_leisure", 0, 3);
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
        },
        hotel: {
          label: 'H'
        },
        grocery: {
          label: 'G'
        },
        shopping: {
          label: 'S'
        },
        leisure: {
          label: 'L'
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
                label: icon.label,
				width: "125px"
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
	
