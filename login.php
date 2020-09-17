<?php
session_start();
$forms = true;
$mission = false;
include 'header.php'; 
 
$email = $_POST['email'];
$password1 = $_POST['password1'];
$submitt = $_POST['submitt'];


if(!$submitt == null){

	
		$errormsg = "";
		$error = false;
		
		if($email == null){
			$error = true;
			$errormsg = $errormsg . "You must enter an email.<br/>";
		}
		
		if($password1 == null){
			$error = true;
			$errormsg = $errormsg . "You must enter a password.<br/>";
		}

		if($error == true){
			errormsg($errormsg);
		}
		else{
			include 'config.php';
			
			$first_name = null;
			$tablename = "users";
			$error = false;
			$rows = 0;
			$user_id = null;
			
			$stmt = $conn->query("SELECT * FROM " . $tablename . " where email='" . $email . "'");
			foreach ($stmt as $row)
			{
				$user_id = $row['user_id'];
				$first_name = $row['first_name'];
				if($password1 == $row['password']){
					
				}
				else{
					$error = true;
				}
				$rows++;
			}
			
			if($rows == 0){
				$error = true;
				
			}
			
			if($error == true){
				errormsg("Incorrect email and/or password.");
			}
			else{
				//Create an un guess-able session
				$number = rand(1, 50000);
				$number1 = rand(1, 50000);
				$int = rand(0,51);
				$a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$rand_letter = $a_z[$int];
				$rand_letter2 = $a_z[$int];
				
				$session = ($number . $rand_letter . rand(1,15) . $number1 . $rand_letter2);
				//Assign that session
				$_SESSION['session'] = $session;
				
				
				//Update database with that session
				$sql = "UPDATE users SET session=? WHERE user_id=?";
				$stmt= $conn->prepare($sql);
				$stmt->execute([$session, $user_id]);
				
			
				successmsg("You have been logged in!<br/>Welcome back, " . $first_name);
				include 'footer.php';
				die();
			}
		
		}
		
	
}
?>
 
 
		<div class="container">
			<div id="formbox">
				<form action="login.php" method="post"><br/><br/>
				<hr>
				<h2 id="form-heading" >Login</h2>
				<hr><br/>
					
					<div class="registration" style="overflow: hidden;">
					
						
							Email<br/>
							<input type="text" name="email" class="input-text-long newBiz"><br/>
							Password<br/>
							<input type="password" name="password1" class="input-text-long newBiz"><br/>
							<input type="hidden" name="submitt" value="true">
							<input type="submit" class="general-button submit" value="Login">
							
					</div>
						<hr><br/>
					<p>Need an account? <a href="register.php">Click here to register.</a></p>
					
			</div>
		</div>
						
<?php 


 
 include 'footer.php';
 ?>