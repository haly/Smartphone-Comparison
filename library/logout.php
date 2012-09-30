<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		
		This script ends a user's session*/
	
	session_name("HALYSESSION");
	session_start();
	session_destroy();
	header('Location: ../fp.php?res=logout');
?>
