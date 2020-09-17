<?php


//Returns the rating 
function getPct($marker_id, $table, $column){
include './config.php';
	
	$totalRow = 0;
	$totalGood = 0;
	
	$stmt = $conn->query("SELECT $column FROM $table WHERE marker_id='$marker_id' and $column is not null");

	foreach ($stmt as $row)
	{
		 $overall = $row[$column];
		 $totalRow++;
		 $totalGood = $totalGood + $row[$column];
		 
	}
	$pct = ($totalGood / $totalRow);
	$pct = (int) $pct;
	
	/***
	if($totalRow == 0){
		$pct = "N/A";
	}
	if($pct < 60){
		$pct = "<li id=\"red\">" . $pct . "</li>";
	}
	else if($pct <= 84){
		$pct = "<li id=\"yellow\">" . $pct . "</li>";
	}
	else if($pct <= 100){
		$pct = "<li id=\"green\">" . $pct . "</li>";
	}
	***/
	
	return $pct;
}

function prettyNumber($number){
	$number = $number *100;
	$number = (int) $number;
	

	return $number;
}

function prettyScore($number){
	$number = prettyNumber($number);

	if($number == 0){
		$number = "N/A";
	}
	if($number < 60){
		$number = "<div class=\"score red\">Rating: <small>%</small>" . $number . "</div>";
	}
	else if($number <= 84){
		$number = "<div class=\"score yellow\">Rating: <small>%</small>" . $number . "</div>";
	}
	else if($number <= 100){
		$number = "<div class=\"score green\">Rating: <small>%</small>" . $number . "</div>";
	}
	return $number;
	
	
}


function getListings($type, $mtype, $joinTable, $limit1, $limit2){
	include './config.php';
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
							
							
							//$stmt = $conn->query('SELECT * FROM  ' . $tablename . ' where type="restaurant"');
							$stmt = $conn->query('SELECT m.*, ' . $joinTable . '.marker_id, AVG(overall) as overall from ' . $joinTable . ' LEFT JOIN markers m on ' . $joinTable . '.marker_id = m.marker_id where m.type = "' . $mtype . '" and overall is not null group by ' . $joinTable . '.marker_id ORDER BY AVG(overall) desc limit ' . $limit1 . ', ' . $limit2);
							echo "<h2 id=\"title\">" . ucfirst($type) . " | Top Accessible</h2>";
							
							$rows = 0;
							
							foreach ($stmt as $row)
							{
								 $name = $row['name'];
								 $formatName = $row['format_name'];
								 $type = $row['type'];
								 $address = $row['address'];
								 $address = str_replace('"', '', $address);
								 $address = str_replace(', USA', '', $address);
								 $marker_id = $row['marker_id'];
								 
								 $overall = prettyScore($row['overall']);
								
								 $rows++;
								 
								 echo "
								 
									<div class=\"listing-container\">
										<div class=\"listing-divider\">
											<a href=\"establishment.php?name=$formatName&id=$marker_id&type=$type\"><img src=\"images/info.png\" id=\"info\">
											<h3 id=\"listing-title\">$name</h3></a><br/>
											
											
											<p id=\"address\"><a href=\"https://www.google.com/search?q=$name+$address\" target=\"_BLANK\">$address</a></p>
											<p><a href=\"\">Directions</a> | <a href=\"new-review.php?type=$type&id=$marker_id\">Write a Review</a>
										</div>
										<div class=\"listing-divider text-right\">
											$overall
								
										</div>
									</div>
								 ";
							}
							$stmt = $conn->query('SELECT * FROM  ' . $tablename . ' where type="' . $mtype . '"');
							
							if($rows == 0){
								foreach ($stmt as $row)
								{
									 $name = $row['name'];
									 $formatName = $row['format_name'];
									 $type = $row['type'];
									 $address = $row['address'];
									 $address = str_replace('"', '', $address);
									 
									 $marker_id = $row['marker_id'];
									 
									 $overall = prettyScore($row['overall']);
									
									 $rows++;
									 
									 echo "
									 
										<div class=\"listing-container\">
											<div class=\"listing-divider\">
												<a href=\"establishment.php?name=$formatName&id=$marker_id&type=$type\"><img src=\"images/info.png\" id=\"info\">
												<h3 id=\"listing-title\">$name</h3></a><br/>
												
												
												<p id=\"address\"><a href=\"https://www.google.com/search?q=$name+$address\" target=\"_BLANK\">$address</a></p>
												<p><a href=\"\">Website</a> | <a href=\"\">Directions</a> | <a href=\"new-review.php?type=$type&id=$marker_id\">Write a Review</a>
											</div>
											<div class=\"listing-divider text-right\">
												 $overall
									
											</div>
										</div>
									 ";
								}
							}
	
}

function getReviews($tablename, $marker_id){
	include './config.php';
	$stmt = $conn->query('SELECT review FROM  ' . $tablename . ' where marker_id="' . $marker_id . '" and review is not null');
		
			foreach ($stmt as $row)
			{
				$review = $row['review'];
				echo "<div class=\"review\">" . $review . "</div>";
			}
}



//Geocoding

// function to geocode address, it will return false if unable to geocode address
function geocode($address){
 
    // url encode the address
    $address = urlencode($address);
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCxPEA41SNQVoYL-AXRDMB6knxWd1LpKMY";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }
 
    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}

?>
