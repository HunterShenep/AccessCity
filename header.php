<?php
error_reporting(0);
session_start();

$currentsession = $_SESSION['session'];

if($currentsession == true){
	
	$header_first_name = null;
	$tablename = 'users';
	include 'config.php';
	$stmt = $conn->query("SELECT * FROM " . $tablename . " where session='" . $currentsession . "'");
		foreach ($stmt as $row)
		{
			$first_name= $row['first_name'];
		}
	
	$loginstuff = "LOGGED IN: " . $first_name . " &nbsp;&nbsp;|&nbsp;&nbsp; <a href=\"logout.php\" style=\"color: #cacaca;\">LOGOUT</a>";
}
else{
	$loginstuff = "<form action=\"login.php\" method=\"post\"><input type=\"hidden\" name=\"submitt\" value=\"true\">
				Email<input type=\"text\" name=\"email\" class=\"nav-input-text\"> Password<input type=\"password\" name=\"password1\" class=\"nav-input-text\"><input type=\"submit\" value=\"LOGIN\" class=\"nav-input-submit\"></form>";
}



function remove_quotes($whatever){
	$whatever = str_replace('"', '', $whatever);
	return $whatever;
}

function listingNumbers($overall){

	 $overall = "<small>%</small>$overall";
	 return $overall;
}
	
function errormsg($message){
		$msg = "
				<div class=\"container restaurant\">

					<div id=\"formbox\">
						<img src=\"images/error.png\"></br></br>
							<p>$message</p>
							<hr>
							If you feel this was a mistake, please contact support.</br></br>
							<a href=\"javascript:history.back()\"><img src=\"images/return.png\"></br>Go Back</a>
					</div>
				</div>";
	echo $msg;
}

function successmsg($message){
		$msg = "
				<div class=\"container restaurant\">

					<div id=\"formbox\">
						<img src=\"images/good.png\">
							<h2>$message</h2>
							<hr>
							<p>What would you like to do now?</p>
							<p><a href=\"index.php\">Home</a> | <a href=\"map.php\">Map</a> | <a href =\"\">Discussion</a> | <a href=\"search-new-review.php\">New Review</a></p>
							
					</div>
				</div>";
	echo $msg;
}


?>

<!DOCTYPE html>
<html>
	<head>
		<?php
		
			if($forms == true){
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/forms.css\" />";
			}
			if($mapslistings == true){
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/maps-listings.css\" />";
			}
		?>
		
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/mobile-opt.css" />
		
		<script>
		var show = 0;
			function showNavLinks() {
				show++;
				if(show % 2 == 1){
					document.getElementById("navLinks").style.display = "block";
				}
				else{
					document.getElementById("navLinks").style.display = "none";
				}
			}
		</script>
	</head>
	<body>

	<div class="navbar">

		<div class="navTitle">
			<h1 class="navh1">Access La Crosse</h1>
			<img src="images/final-logo-hq.png" class="logo">
			
		</div>
		<div class="navLinks" id="navLinks">
			<a href="index.php" class="nav">Home</a> 
			<a href="map.php" class="nav">Maps</a> 
			<a href="contact" class="nav">Discussion</a> 
			<a href="map.php" class="nav">Support</a> 
			<?php
			if($currentsession == null){
				echo "<a href=\"register.php\" class=\"nav\">Register</a>";
			}
			else{
				
			}
			
			?>
			<div class="navLogin">
				<?php echo $loginstuff; ?>
			</div>
		</div>
		<div class="menuButton">
			<img src="images/menu.png" class="menu" onclick="showNavLinks()">
		</div>
	</div>
	<?php
		if(!isset($mission)){
	?>
	<div class="our-mission-cont">
		<div class="our-mission">
			<h1 style="color: #000000;">Our Mission.</h1>
			<p id="stroke">
				Access Our City is dedicated to providing the La Crosse community 
				information on disability inclusive businesses in the area. 
				Use our map to help plan your day around town.
			</p>
			<a href="map.php?type=all#mtitle"><div class="general-button">View Map</div></a>
		</div>
	</div>
	<div class="main-container">
	<?php
		}
	?>