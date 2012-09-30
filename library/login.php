<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		
		This script starts a user session given a pssword
		and handle any errors related to logging in.*/
	
	$u = $_POST['user'];
	$p = md5($_POST['pw']);
	include ("securityWrapper.php");
	$sec = new Security();
	$userExists = $sec->loadUser($u);
	
	if ($userExists)
	{
		if ($p == $sec->getPwd())
		{
			session_name("HALYSESSION");
			session_start();
			$_SESSION["user"] = $u;
			$_SESSION["fname"] = $sec->getFirstName();
			$_SESSION["lname"] = $sec->getLastName();
			$_SESSION["email"] = $sec->getEmail();
			header('Location: ./productSelect.php');
		}
		else
			header('Location: ../fp.php?res=wrongpw');
	}
	else
		header('Location: ../fp.php?res=nouser');
?>
