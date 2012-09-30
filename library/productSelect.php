<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		This file creates a session if the previous session has expired, and sets a 
		flag used to inform the user of their session change*/
	
	include("sessionCheck.php");
	include("productWrapper.php");
	$productDB = new Product();
?>
	
<!DOCTYPE html>
<head>
	<title>Server Side Programming: Final Project</title>
	<link rel="stylesheet" type="text/css" href="../css/fp.css"/>
	<script language="JavaScript">
		// Returns the number of phones currently selected
		function numSelected()
		{
			var count = 0;
			var checks = document.getElementsByName("idCheck[]");
			for(var i = 0; i < checks.length; i++)
			{
				if (checks[i].disabled == false)
					count++;
			}
			return count;
		}
		// Limits the total number of selected phones to 5
		function limitCheck()
		{
			if (numSelected() < 5)
				return true
			else
			{
				alert("You can only choose 5 phones!");
				return false;
			}
		}
		// Checks to make sure if at least one phone was selected
		function validateSelection()
		{
			if (numSelected() > 0)
				return true;
			else
			{
				alert("You must select at least one phone.");
				return false;
			}
		}
		// Checks or unchecks a box, used by each phone's table cell
		function checkBox($id)
		{
			var ele = document.getElementById($id);
			if (ele.disabled == false)
			{
				ele.disabled = true;
				document.getElementById($id + "Cell").className = "phonetable unselected"; 
			}
			else
			{
				var check = limitCheck();
				if (check)
				{
					ele.disabled = false;
					document.getElementById($id + "Cell").className = "phonetable selected"; 
				}
			}
		}
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
		</div>
		<h3>Smartphone Selection</h3>	
		<br>
		<br>
		<form action="productCompare.php" method="get">
			<?php
				$productDB->getProductList(5);
			?>
			<br>
			<div class="compare">
				<input type="submit" value="Compare" onsubmit="return validateSelection()" class="flatbutton comparebutton"/>
			</div>
		</form>
	</div>
</body>
