<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		This script checks to see if the "user" variable in the $_SESSION array is set.
		If not, it redirects the client to the login page.*/
		
	// Checks to see if there is a preexisting session
	session_name("HALYSESSION");
	session_start();
	if (!isset($_SESSION["user"]))
	{
		header('Location: ../fp.php?res=expire');
	}
?>