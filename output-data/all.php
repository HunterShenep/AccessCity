<?php
include '../config.php';

function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','',$xmlStr);
	//$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}


try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	//error_reporting(0);
	$tablename = "markers";
	
	$stmt = $conn->query('SELECT * FROM  ' . $tablename . '');
	header("Content-type: text/xml");

	// Start XML file, echo parent node
	echo "<?xml version='1.0' ?>";
	echo '<markers>';
			foreach ($stmt as $row)
			{
				  echo '<marker ';
				  echo 'id="' . $row['marker_id'] . '" ';
				  echo 'name="' . parseToXML($row['name']) . '" ';
				  echo 'address="' . parseToXML($row['address']) . '" ';
				  echo 'lat="' . $row['lat'] . '" ';
				  echo 'lng="' . $row['lng'] . '" ';
				  echo 'type="' . $row['type'] . '" ';
				 // echo 'overall="' . $row['overall'] . '" ';
				  echo '/>';
				  $ind = $ind + 1;
				
			}
// End XML file
echo '</markers>';

?>