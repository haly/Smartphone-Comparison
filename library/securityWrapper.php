<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		
		A wrapper class for a security database*/
		
		
	class Security
	{
		// Variables
		private $dbselect;
		private $userTable;
		private $currentUser;
		private $userInfo;
		
		// Functions
		public function __construct()
		{	
			// Gets values from a config.xml file
			$config = "http://halygames.com/projects/fp/xml/config.xml";
			
			$dom = new DomDocument();
			$dom->load($config);
			$root = $dom->documentElement;
			
			$dbServer = $root->getElementsByTagName("dbServer")->item(0)->nodeValue;
			$dbName = $root->getElementsByTagName("dbName")->item(0)->nodeValue;
			$dbLogin = $root->getElementsByTagName("dbLogin")->item(0)->nodeValue;
			$dbPwd = $root->getElementsByTagName("dbPwd")->item(0)->nodeValue;
			
			$this->userTable = $root->getElementsByTagName("usrTbl")->item(0)->nodeValue;
			
			// Logs into the local host
			$connection = mysql_connect($dbServer, $dbLogin, $dbPwd);
			if ($connection == false)
				die("<br>Login to $dbLogin failed: " . mysql_error());
			
			// Creates a handle to the database where the security table is stored
			$dbselect = mysql_selectdb($dbName, $connection);
			if (isset($dbSelect))
				die("<br>Database $dbName was not selected: " . mysql_error());
		}
		
		// Loads a user by his or her username
		public function loadUser($username)
		{
			// Query the database
			$userExists = mysql_query("SELECT * FROM $this->userTable WHERE username = '$username';");
			
			// If results are valid, return true, and set currentuser as the passed user
			if (mysql_num_rows($userExists) == 1)
			{
				$this->currentUser = $username;
				return true;
			}
			else
			{
				return false;
			}
		}
		
		// Creates a new user from parameters
		public function saveUser($username, $md5pw, $firstName, $lastName, $email)
		{
			$result = mysql_query("	INSERT INTO $this->userTable (username, md5password, firstname, lastname, email)
										VALUES('$username', '$md5pw', '$firstName', '$lastName', '$email');");
			return $result;
		}
		
		// Mutators
		public function setPwd($md5pw)
		{
			mysql_query("	UPDATE $this->userTable 
							SET md5Password = '$md5pw' 
							WHERE username = '$this->currentUser';");
		}
		
		public function setFirstName($newFirstName)
		{
			mysql_query("	UPDATE $this->userTable 
							SET firstname = '$newLastName' 
							WHERE username = '$this->currentUser';");
		}
		
		public function setLastName($newLastName)
		{
			mysql_query("	UPDATE $this->userTable 
							SET lastname = '$newFirstName' 
							WHERE username = '$this->currentUser';");
		}
		
		public function setEmail($newEmail)
		{
			mysql_query("	UPDATE $this->userTable 
							SET email = '$newMail' 
							WHERE username = '$this->currentUser';");
		}
		
		// Accessors
		public function getPwd()
		{
			$this->updateInfo();
			return $this->userInfo["md5Password"];
		}
	
		public function getFirstName()
		{
			$this->updateInfo();
			return $this->userInfo["firstname"];
		}
		
		public function getLastName()
		{
			$this->updateInfo();
			return $this->userInfo["lastname"];
		}
		
		public function getEmail()
		{
			$this->updateInfo();
			return $this->userInfo["email"];
		}
		
		// Utility function to update the current user's information for
		// up-to-date information without requiring the user to reload the page
		public function updateInfo()
		{
			$result = mysql_query("SELECT * FROM $this->userTable WHERE username = '$this->currentUser';");
			$this->userInfo = mysql_fetch_assoc($result);
		}
	}
?>