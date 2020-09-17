<?php 
include 'session.php';
$mission = false;
$forms = true;
include 'header.php'; 
$type = $_GET['type'];
$id = $_GET['id'];

function yesno($input, $question){
	$message = "
		<div id=\"question\">
			<h3>$question</h3><br/>
			<div id=\"yn-cont\">
				<input id=\"$input-on\" name=\"$input\" type=\"radio\" value=\"1\">
				<label for=\"$input-on\" class=\"label\">Yes</label>
				
				<input id=\"$input-off\" name=\"$input\" type=\"radio\" value=\"0\">
				<label for=\"$input-off\" class=\"label no\">No</label>
			</div>
		</div>
	";
	echo $message;
}



if((!$type == null) && (!$id == null)){

	$verified = 0;
	$pulled_id = null;
	$pulled_type = null;
	$name = null;
	$address = null;


	/***** GRAB BASIC INFO FROM ID THAT WAS PASSED *****/
	include 'config.php';
	try {
		$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}

	$stmt = $conn->query("SELECT * FROM markers where marker_id='$id'");

	foreach ($stmt as $row)
	{
		 $pulled_id = $row['marker_id'];
		 $name = $row['name'];
		 $address = $row['address'];
		 $pulled_type = $row['type'];

	}
	?>
<div class="container restaurant">

	<div id="formbox">
	<?php
/***** END GRAB BASIC INFO FROM ID THAT WAS PASSED *****/
//Verify that the ID that was passed matches something in the database, and types are the same.
	if(($pulled_id == $id) && ($type == $pulled_type)){

		if($type == "restaurant"){
		
?>

			<form action="submit-new-review.php" method="POST">
				<h2>
					<?php
						echo $name . "</h2><h3 id=\"review-h3\">";
						echo remove_quotes($address) . "</h3>";
					?>
				
				<?php 
					yesno(overall, "Is this a good experience overall?");
					yesno(parking, "Is there accessible parking?");
					yesno(button, 'Is there a "Press To Open" button for the entrance?');
					yesno(tables, 'Are the tables accessible to you?');
					yesno(bathrooms, 'Are the bathrooms accessible to you?');
				
				?>
				
				<div id="question">
					<h3>Your experience (Optional)</h3><br/>
					<textarea name="review" id="review-textarea"></textarea>
					<input type="submit" value="Submit" class="general-button submit">
				</div>
				<input type="hidden" name="marker_id" value="<?php echo $pulled_id; ?>">
				<input type="hidden" name="type" value="<?php echo $pulled_type; ?>">
				
			</form>

		<?php
		}
		else if($type == "shopping"){
			?>
				<form action="submit-new-review.php" method="POST">
					<h2>
						<?php
							echo $name . "</h2><h3 id=\"review-h3\">";
							echo remove_quotes($address) . "</h3>";
						?>
					
					<?php 
						yesno(overall, "Is this a good experience overall?");
						yesno(parking, "Is there accessible parking?");
						yesno(entrance, 'Is there a "Press To Open" button or automatic opening doors for the entrance?');
						yesno(walkways, 'Are the walkways/aisles accessible to you?');
						yesno(bathrooms, 'Are the bathrooms accessible to you?');
					
					?>
					
					<div id="question">
						<h3>Your experience (Optional)</h3><br/>
						<textarea name="review" id="review-textarea"></textarea>
						<input type="submit" value="Submit" class="general-button submit">
					</div>
					<input type="hidden" name="marker_id" value="<?php echo $pulled_id; ?>">
					<input type="hidden" name="type" value="<?php echo $pulled_type; ?>">
					
			<?php
		}
		else if($type == "grocery" || $type == "leisure"){
			?>
				<form action="submit-new-review.php" method="POST">
					<h2>
						<?php
							echo $name . "</h2><h3 id=\"review-h3\">";
							echo remove_quotes($address) . "</h3>";
						?>
					
					<?php 
						yesno(overall, "Is this a good experience overall?");
						yesno(parking, "Is there accessible parking?");
						yesno(entrance, 'Is there a "Press To Open" button or automatic opening doors for the entrance?');
						yesno(walkways, 'Are the walkways/aisles accessible to you?');
						yesno(bathrooms, 'Are the bathrooms accessible to you?');
					
					?>
					
					<div id="question">
						<h3>Your experience (Optional)</h3><br/>
						<textarea name="review" id="review-textarea"></textarea>
						<input type="submit" value="Submit" class="general-button submit">
					</div>
					<input type="hidden" name="marker_id" value="<?php echo $pulled_id; ?>">
					<input type="hidden" name="type" value="<?php echo $pulled_type; ?>">
			<?php
		}
		
		else if($type == "hotel"){
			?>
				<form action="submit-new-review.php" method="POST">
					<h2>
						<?php
							echo $name . "</h2><h3 id=\"review-h3\">";
							echo remove_quotes($address) . "</h3>";
						?>
					
					<?php 
						yesno(overall, "Is this a good experience overall?");
						yesno(parking, "Is there accessible parking?");
						yesno(entrance, 'Is there a "Press To Open" button or automatic opening doors for the entrance?');
						yesno(walkways, 'Are the walkways/aisles accessible to you?');
						yesno(rooms, 'Are the hotel rooms accessible to you?');
						yesno(bathrooms, 'Are the bathrooms accessible to you?');
						
					
					?>
					
					<div id="question">
						<h3>Your experience (Optional)</h3><br/>
						<textarea name="review" id="review-textarea"></textarea>
						<input type="submit" value="Submit" class="general-button submit">
					</div>
					<input type="hidden" name="marker_id" value="<?php echo $pulled_id; ?>">
					<input type="hidden" name="type" value="<?php echo $pulled_type; ?>">
			<?php
		}
	}
	else{
		errormsg("ID did not match anything in the database, or the type was incorrect for this ID");
	}
		
}
else{
	errormsg("Type and or ID missing");
}
		?>
	</div>
</div>

<?php include 'footer.php';?>