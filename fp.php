<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		*/
?>
<!DOCTYPE html>
<head>
	<title>Server Side Programming: Final Project</title>
	<link rel="stylesheet" type="text/css" href="css/fp.css"/>
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
			
			<h3>Login:</h3>
			<form action="library/login.php" method="post">
				<label for="user">Username:</label> <br>
					<input type="text" name="user" id="user" class="flatbox"/><br>
				<label for="pw">Password:</label> <br>
					<input type="password" name="pw" id="pw" class="flatbox"/><br>
				<input type="submit" value="Login" class="flatbutton"/>
			</form>
			<?php
				$result = $_GET['res'];
				if ($result == 'sent')
					echo "<div class='success'>New password sent</div>";
				else if ($result == 'newuser')
					echo "<div class='success'>Success! Please log in with your new account</div>";
				else if ($result == 'wrongpw')
					echo "<div class='error'>Password not recognized</div>";
				else if ($result == 'nouser')
					echo "<div class='error'>User does not exist</div>";
			?>
			<a href="library/getpassword.php">Forgot your password?</a>
			<br>
			<a href="library/register.php?do=register">Click to create a new account</a>
		</div>
	</div>
	</div>
</body>