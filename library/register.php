<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		
		This script checks to make sure a user creation
		request is valid.*/
		
	$d = $_GET['do'];
	if ($d == 'register')
	{
		$firstTime = true;
	}
	if ($d == "adduser")
	{	
		include ("securityWrapper.php");
		$sec = new Security();
		
		$u = $_POST['user'];
		$p = md5($_POST['pw']);
		$f = $_POST['fname'];
		$l = $_POST['lname'];
		$e = $_POST['email'];
		
		if (isset($_POST['user']) &&
			isset($_POST['pw']) &&
			isset($_POST['fname']) &&
			isset($_POST['lname']) &&
			isset($_POST['email']))
		{
			if ($sec->saveUser($u, $p, $f, $l, $e) == NULL)
			{
				$duplicate = true;
			}
			else
			{
				header('Location: ../fp.php?res=newuser'); 
			}
		}
	}
?>
	
<!DOCTYPE html>
<head>
	<title>Server Side Programming: Final Project</title>
	<link rel="stylesheet" type="text/css" href="../css/fp.css"/>
	<script language="JavaScript">
		function validateForm(user, pw, repw, fname, lname, email)
		{
		}
		function passwordCheck(pw1, pw2)
		{
			if (pw1.value == '' || pw2.value == '')
			{
				alert("Please fill out both password fields.");
				return false;
			}
			else if (pw1.value != pw2.value)
			{
				alert("Passwords don't match.");
				return false
			}
			else
			{
				return true;
			}
			return false;
		}
	</script>
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
			
			<?php
				echo "<h3>Account Creation</h3>";
				echo "<form action='register.php?do=adduser' method='post' onsubmit='return passwordCheck(pw, repw)'>";
					echo "<label for='user'>Username: </label> <br>";
						echo "<input type='text' name='user' class='flatbox'/><br>";
						if (!isset($_POST['user']) && !$firstTime)
							echo "<div class='error'>You must choose a username.</div>";
						else if ($duplicate)
							echo "<div class='error'>User already exists.</div>";
					echo "<label for='pw'>Password: </label> <br>";
						echo "<input type='password' name='pw' class='flatbox'/><br>";
					echo "<label for='repw'>Re-enter password: </label> <br>";
						echo "<input type='password' name='repw' class='flatbox'/><br>";
					echo "<label for='fname'>First Name: </label> <br>";
						echo "<input type='text' name='fname' class='flatbox'/><br>";
						if (!isset($_POST['fname']) && !$firstTime)
							echo "<div class='error'>You must provide your first name.</div>";
					echo "<label for='lname'>Last Name: </label> <br>";
						echo "<input type='text' name='lname' class='flatbox'/><br>";
						if (!isset($_POST['lname']) && !$firstTime)
							echo "<div class='error'>You must provide your first name.</div>";
					echo "<label for='email'>Email: </label> <br>";
						echo "<input type='text' name='email' class='flatbox'/><br>";
						if (!isset($_POST['email']) && !$firstTime)
							echo "<div class='error'>You must provide an email.</div>";
					echo "<input type='submit' value='Create Account' class='flatbutton' />";
				echo "</form>";
			?>
		</div>
	</div>
</body>
