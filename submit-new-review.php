<?php 
include 'session.php';
$mission = false;
$forms = true;
include 'header.php'; 

$marker_id = $_POST['marker_id'];
$type = $_POST['type'];

$thankyou_message = ("					<div class=\"container restaurant\">

						<div id=\"formbox\">
							<h1>Thank you for your review</h1>
							<h3>What would you like to do now?</h3>
							<a href=\"index.php\">Home</a> | <a href=\"map.php\">Maps</a> | <a href=\"discussion.php\">Discussions</a>
							</div></div>
							");


if(isset($marker_id) && isset($type)){
	$overall = $_POST['overall'];
	
	if(isset($overall)){
		if($type == "restaurant"){
			
			$parking = $_POST['parking'];
			$open_button = $_POST['button'];
			$tables = $_POST['tables'];
			$bathrooms = $_POST['bathrooms'];
			$review = $_POST['review'];
			
			
			//Insert
			include 'config.php';
			$tablename = "review_restaurant";
			
			$stmt = $conn->prepare('INSERT INTO ' . $tablename . ' (review_restaurant_id, marker_id, user_id, date, overall, parking, open_button, tables, bathrooms, review) VALUES(NULL, :marker_id, :user_id, CURDATE(), :overall, :parking, :open_button, :tables, :bathrooms, :review)');
				$stmt->bindValue(':marker_id', $marker_id);
				$stmt->bindValue(':user_id', $user_id);
				$stmt->bindValue(':overall', $overall);
				$stmt->bindValue(':parking', $parking);
				$stmt->bindValue(':open_button', $open_button);
				$stmt->bindValue(':tables', $tables);
				$stmt->bindValue(':bathrooms', $bathrooms);
				$stmt->bindValue(':review', $review);
				$stmt->execute();
				
				echo $thankyou_message;
		}
		else if($type == "shopping" || $type == "grocery" || $type == "leisure"){
			
			$parking = $_POST['parking'];
			$entrance = $_POST['entrance'];
			$walkways = $_POST['walkways'];
			$bathrooms = $_POST['bathrooms'];
			$review = $_POST['review'];
			
			include 'config.php';
			$tablename = "review_" . $type;
			
			$stmt = $conn->prepare('INSERT INTO ' . $tablename . ' (review_' . $type . '_id, marker_id, user_id, date, overall, parking, entrance, walkways, bathrooms, review) VALUES(NULL, :marker_id, :user_id, CURDATE(), :overall, :parking, :entrance, :walkways, :bathrooms, :review)');
			
				$stmt->bindValue(':marker_id', $marker_id);
				$stmt->bindValue(':user_id', $user_id);
				$stmt->bindValue(':overall', $overall);
				$stmt->bindValue(':parking', $parking);
				$stmt->bindValue(':entrance', $entrance);
				$stmt->bindValue(':walkways', $walkways);
				$stmt->bindValue(':bathrooms', $bathrooms);
				$stmt->bindValue(':review', $review);
				$stmt->execute();
				echo $thankyou_message;
		}
		else if($type == "hotel"){
			
			$parking = $_POST['parking'];
			$entrance = $_POST['entrance'];
			$walkways = $_POST['walkways'];
			$bathrooms = $_POST['bathrooms'];
			$rooms = $_POST['rooms'];
			$review = $_POST['review'];
			
			include 'config.php';
			$tablename = "review_" . $type;
			
			$stmt = $conn->prepare('INSERT INTO ' . $tablename . ' (review_' . $type . '_id, marker_id, user_id, date, overall, parking, entrance, walkways, bathrooms, rooms, review) VALUES(NULL, :marker_id, :user_id, CURDATE(), :overall, :parking, :entrance, :walkways, :bathrooms, :rooms, :review)');
			
				$stmt->bindValue(':marker_id', $marker_id);
				$stmt->bindValue(':user_id', $user_id);
				$stmt->bindValue(':overall', $overall);
				$stmt->bindValue(':parking', $parking);
				$stmt->bindValue(':entrance', $entrance);
				$stmt->bindValue(':walkways', $walkways);
				$stmt->bindValue(':bathrooms', $bathrooms);
				$stmt->bindValue(':rooms', $bathrooms);
				$stmt->bindValue(':review', $review);
				$stmt->execute();
				echo $thankyou_message;
		}
	}
	else{
		errormsg("You must specify Yes/No for \"good experience overall\"");
	}
	
}

?>




<?php include 'footer.php'; ?>