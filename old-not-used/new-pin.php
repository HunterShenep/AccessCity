<?php 
$forms = true;
include 'header.php'; ?>
	
		<div class="container" id="containerMain">
			<div id="formbox">
			
				<h2 id="form-heading">
					What type of review is this?
				</h2>
				
				<div id="sub-type" onclick="openRestaurant()">
					<h3>Restaurant</h3>
				</div>
				
				<div id="sub-type" onclick="openPedestrial()">
					<h3>Pedestrial</h3>
				</div>
				
			</div>
		</div>
		

		
		
		
		
		
		
	
	
	<script>
		function openRestaurant(){
			document.getElementById("containerMain").style.display = "none";
			document.getElementById("containerRestaurant").style.display = "block";
		}
		
		function openPedestrial(){
			document.getElementById("containerMain").style.display = "none";
		}
	</script>
	
	</body>
</html>