<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		*/
		
	include ("securityWrapper.php");
	$sec = new Security();
	
	if (isset($_POST['user']) && $_POST['user'] != "")
	{
		if ($sec->loadUser($_POST['user']))
		{
			// Create a new password
			$base = rand(10e9, 10e13);
			$newpass = base_convert($base, 10, 36);
			
			// Change the password for the specificed user account
			$sec->setPwd(md5($newpass));

			// Send the password to the user
			$to = $sec->getEmail();
			$subject = "Password Reset for Smart Phone Comparison Web App";
			$message = "Your new password is: <b>$newpass</b>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			mail($to, $subject, $message, $headers, '-fFrancisYuan@nova.it.rit.edu');
			
			// Redirect to login
			header('Location: ../fp.php?res=sent');
		}
	}
?>
<!DOCTYPE html>
<head>
	<title>Server Side Programming: Final Project</title>
	<link rel="stylesheet" type="text/css" href="../css/fp.css"/>
</head>

<body>
	<div class="main">
		<div class="banner">
			Smart Phone Comparison Web App
		</div>
		
		<div class="content">
			<div class="info">
				<?php
					echo date('m/d/Y h:i A') . "<br>";
				?>
			</div>
			
			<h3>Get a New Password:</h3>
			<form action="getpassword.php" method="post">
				<label for="user">Your Account Name:</label> <br>
					<input type="text" name="user" id="user" class="flatbox"/><br>
				<input type="submit" value="Send Password" class="flatbutton"/>
			</form>
			<a href="../fp.php">Return to Log in page</a>
		</div>
	</div>
	</div>
</body>