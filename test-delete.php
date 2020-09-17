<?php
	
include 'output-data/general.php';
$arr = geocode("100 3rd St S, La Crosse, WI 54601");
$count = count($arr, COUNT_RECURSIVE);
echo $arr[0];
echo "THe count is: " . $count;
echo "</br></br>";

	for($i=0; $i<$count;$i++){
		
		echo $arr[$i] . " <br/>";
		
	}
?>