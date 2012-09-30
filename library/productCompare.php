<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		This file creates a session if the previous session has expired, and sets a 
		flag used to inform the user of their session change*/
	
	include("sessionCheck.php");
	include("productWrapper.php");
	$productDB = new Product();
	
	foreach($_GET['idCheck'] as $value)
	{
		if(count($phoneID) < 5)
		{
			$phoneID[] = $value;
			$phonesAsUrl .= '&idCheck[]='.$value;
		}
	}
	
	if (isset($_GET['do']) && 
		isset($_GET['idCheck']) && 
		$_GET['do'] == 'mail')
	{
		// Send phone table to the user
		$to = $_SESSION["email"];
		$subject = "Smartphone Comparison";
		$message = $productDB->getProductAttributeListString($phoneID);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers, '-fFrancisYuan@nova.it.rit.edu');
	}	
?>
	
<!DOCTYPE html>
<head>
	<title>Server Side Programming: Final Project</title>
	<link rel="stylesheet" type="text/css" href="../css/fp.css"/>
	<script language="JavaScript">
	</script>
</head>

<body>
	<div class="banner">
		Smart Phone Comparison Web App
	</div>
	<div class="content">
		<div class="info">
			<?php
				echo date('m/d/Y h:i A');
				echo "<br>";
				echo "Welcome " . $_SESSION['fname'] . " " . $_SESSION['lname'];
			?>
			<br>
			<a href="logout.php">Log out</a>
			<br>
			<a href="productSelect.php">Return to selection page</a>
			<br>
			<?php
				echo "<a href='productCompare.php?do=mail$phonesAsUrl'>Send to my email</a>";
			?>
		</div>	
		<h3>Smartphone Comparison</h3>
		<?php
			if ($_GET['do'] == 'mail')
				echo "<div class='success'>Phone tommparison table sent</div>";
		?>
		<br>
		<br>
		<br>
		<br>
		<?php
			if(isset($_GET['idCheck']))
				$productDB->getProductAttributeList($phoneID);
		?>
		<br>
		<div class="info">
			<a href="productSelect.php">Return to selection page</a>
			<br>
			<?php
				echo "<a href='productCompare.php?do=mail$phonesAsUrl'>Send to my email</a>";
			?>
		</div>
	</div>	
</body>
