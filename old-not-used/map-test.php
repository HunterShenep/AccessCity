<?php include 'header.php'; ?>

    <div id="map"></div>
    <script>
	
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: 43.81671385031048, lng: -91.24170805358885};
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
	document.getElementById("orig").value = "";
	document.getElementById("lat").value = "";
	document.getElementById("long").value = "";
}

    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1w3MQvQMsQ_trICx5OyuyIzJbm8CUFPw&callback=initMap">
    </script>
	</br></br>
		Original: <input type="text" id="orig" style="width: 500px;" value="a"></br>
		Lat <input type="text" id="lat" style="width: 255px;" value="a"></br>
		Long <input type="text" id="long" style="width: 240px;" value="a"></br>
		<p id="test"></p>
		
		</br></br><input type="button" onclick="clearr()" value="Clear">
  </body>
</html>