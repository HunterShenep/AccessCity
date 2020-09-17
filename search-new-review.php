<?php
include 'session.php';

$forms = true;
$mission = false;
 include 'header.php'; 
 
 ?>

		<div class="container">
			<div id="formbox">
			
				<h2 id="form-heading">
					<hr>
					What establishment are you reviewing?</h2>
					<form action="search-new-review.php" method="post" style="padding-bottom: 24px;">
					
						<input type="text" name="search" class="input-text-long"><input type="submit" class="input-search" value="Search">
					</form>
					<hr>
					<?php
						$search = $_POST['search'];
						if(!$search == null){
								include 'config.php';
							
							
							$stmt = $conn->query("SELECT * FROM markers where format_name LIKE '%" . $search . "%'");
							foreach ($stmt as $row)
							{
								 $name = $row['name'];
								 $address = $row['address'];
								 $type = $row['type'];
								 $marker_id = $row['marker_id'];
								 echo "<a href=\"new-review.php?type=$type&id=$marker_id\"><div id=\"search-result\"><div id=\"search-result-left\">$name </br> " . remove_quotes($address) .  "</div><div id=\"search-result-right\">
								 <img src=\"images/go.png\" id=\"new-review-icon\"></div></a></div>";
							}
							echo "<h3>Didn't find what you were looking for?</h3><h3><a href=\"new-business.php\">Click here</a> to add a new business</h3>";
						}
					?>
			</div>
					
		</div>
		
	</div>
	
</div>
				
<?php include 'footer.php';?>