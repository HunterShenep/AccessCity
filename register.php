<?php
$forms = true;
$mission = false;
include 'header.php'; 
 
$email = $_POST['email']; 
$password1 = $_POST['password1']; 
$password2 = $_POST['password2']; 
$fname = $_POST['fname']; 
$lname = $_POST['lname']; 

$error = false;
$errormsgg = "";


if(!$email == null){
	
	if($password1 == null){
		$error = true;
		$errormsgg = $errormsgg . "You must enter a password!</br>";
	}
	
	if($password2 == null){
		$error = true;
		$errormsgg = $errormsgg . "You must confirm your password!</br>";
	}
	
	if($fname == null){
		$error = true;
		$errormsgg = $errormsgg . "Please enter a first name!</br>";
	}
	
	if($lname == null){
		$error = true;
		$errormsgg = $errormsgg . "Please enter a last name!</br>";
	}
	
	if(!($password1 == $password2)){
		$error = true;
		$errormsgg = $errormsgg . "Your passwords do not match!</br>";
	}
	
	if(strpos($email, '@') == false){
		$error = true;
		$errormsgg = $errormsgg . "Please enter a valid email!</br>";
	}
	if(strpos($email, '.') == false){
		$error = true;
		$errormsgg = $errormsgg . "Please enter a valid email!</br>";
	}
	
	if($error == true){
		errormsg($errormsgg);
	}
	else{
		include 'config.php';
		
		$tablename = "users";
			
		$exists = 0;
		$stmt = $conn->query("SELECT * FROM " . $tablename . " where email='" . $email . "'");
		foreach ($stmt as $row)
		{
			 $exists++;
		}
		
		
		if($exists > 0){
			errormsg("There is already an account associated with this email address.");
			
		}
		else{
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$stmt = $conn->prepare('INSERT INTO ' . $tablename . ' (user_id, email, first_name, last_name, password, session, date_registered, ip_registered, account_type, banned, review_count) VALUES(NULL, :email, :first_name, :last_name, :password, NULL, CURDATE(), :ip, "0", "0", "0")');
				$stmt->bindValue(':email', $email);
				$stmt->bindValue(':first_name', $fname);
				$stmt->bindValue(':last_name', $lname);
				$stmt->bindValue(':password', $password1);
				$stmt->bindValue(':ip', $ip);
				$stmt->execute();
				successmsg("Account created!");
				include 'footer.php';
				die();
		}	
			
	}
	
}



 
 
 
 ?>

		<div class="container">
			<div id="formbox">
				<form action="register.php" method="post">
				<h2 id="form-heading" >
					<hr>
					Registration</h2>
					<div class="registration" style="overflow: hidden;">
						Email<br/>
						<input type="text" name="email" class="input-text-long newBiz" value=""><br/>
						
						Password<br/>
						<input type="password" name="password1" class="input-text-long newBiz" value=""><br/>
						
						Confirm Password<br/>
						<input type="password" name="password2" class="input-text-long newBiz" value=""><br/>
						
						First Name<br/>
						<input type="text" name="fname" class="input-text-long newBiz" value=""><br/>
						
						Last Name<br/>
						<input type="text" name="lname" class="input-text-long newBiz" value=""><br/>
						
						<input type="submit" class="general-button submit" value="Register">
				
					</div>
				</form>
			<hr><br/><br/>
		</div></div>
		
		<?php include 'footer.php';?>