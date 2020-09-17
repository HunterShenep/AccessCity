<?php
session_start();
 include 'config.php';
date_default_timezone_set('America/Chicago');
$time = date('g:i A', time());
$currentsession = $_SESSION['session'];
//echo "<h1>SESSION: " . $currentsession . "</h1>";
	$tablename = 'users';
	$rows = 0;
	$banned = 0;
	$user_id = null;
	$first_name = null;
	
	if ($currentsession == NULL) {
		die("<meta http-equiv=\"refresh\" content=\"0; URL='login.php'\" />");
	}
	else{
	
		$stmt = $conn->query("SELECT * FROM " . $tablename . " where session='" . $currentsession . "'");
		foreach ($stmt as $row)
		{
			$rows++;
			$banned = $row['banned'];
			$user_id = $row['user_id'];
			$first_name= $row['first_name'];
		}
		
		if($rows > 0){
			if($banned == 1){
				
				echo("<h1>This account has been disabled.</h1>");
				die();
			}
		}
		else{
			die("<meta http-equiv=\"refresh\" content=\"0; URL='login.php'\" />");
		}
	}
?>