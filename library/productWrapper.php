<?php
	/*	Page Author: Francis Yuan	
		Email: fxy2444@rit.edu		
		
		A wrapper class for a product database and a product attribute database*/
			
	class Product
	{
		// Variables
		private $dbselect;
		private $productTable;
		private $productAttrTable;
		
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
			
			$this->productTable = $root->getElementsByTagName("productTbl")->item(0)->nodeValue;
			$this->productAttrTable = $root->getElementsByTagName("prodAttr")->item(0)->nodeValue;
			
			// Logs into the local host 
			$connection = mysql_connect($dbServer, $dbLogin, $dbPwd);
			if ($connection == false)
				die("<br>Login to $dbLogin failed: " . mysql_error());
				
				// Creates a handle to the database where the security table is stored
			$dbselect = mysql_selectdb($dbName, $connection);
			if (isset($dbSelect))
				die("<br>Database $dbName was not selected: " . mysql_error());
		}
		
		// Returns basic product information by its id
		public function loadProductByID($productID)
		{
			$result = mysql_query("	SELECT name, pictureURL 
									FROM $this->productTable
									WHERE id = '$productID';");
			return $result;
		}
		
		// Returns a product's attributes by its id
		public function loadProductAttrByID($productID)
		{
			$result = mysql_query("	SELECT Name, value
									FROM $this->productAttrTable
									WHERE prodFK = '$productID';");
									
			return $result;
		}
		
		// Returns a $w cells wide table of products for selection
		public function getProductList($w)
		{
			// Get a list of products from the productTable
			$result = mysql_query("	SELECT * FROM $this->productTable");
			
			// Begin table
			echo "<table>";
			// Loops through every product and inserts them into the table
			for ($i = 0; $row = mysql_fetch_assoc($result); $i++)
			{
				$id = $row["id"];
				$name = $row["name"];
				$pic = $row["pictureURL"];
				
				// If this is the first cell in a row
				if($i % $w == 0)
					// Open the table row tag
					echo "<tr>";
					
				// Echo product information in a table cell
				echo "<td id='" . $id . "Cell' onClick='checkBox($id)' class='phonetable'>";
				echo "$name";
				echo "<br>";
				echo "<img src='$pic' alt='$name'/>";
				echo "<br>";
				echo "<input type='hidden' disabled='disabled' name='idCheck[]' id='$id' value='$id'/>";
				echo "</td>";	
				
				// If this is the last cell in a row
				if($i % $w == $w - 1) 
					// Close the table row tag
					echo "</tr>";
			}	
			// End table
			echo "</table>";
		}

		
		// Returns a list table of product attributes from an array of product ids
		public function getProductAttributeList($productList)
		{
			// Begin table
			echo "<table>";
			
			// Begin initial row
			echo "<tr>";
			echo "<td class='phonetable'>Features</td>";
			// Echo the name and picture of each phone in a table cell
			for($i = 0; $i < count($productList); $i++)
			{
				$phoneHeader = mysql_fetch_assoc($this->loadProductByID($productList[$i]));
				
				$name = $phoneHeader["name"];
				$pic = $phoneHeader["pictureURL"];
				
				echo "<td class='phonetable'>";
				echo "$name";
				echo "<br>";
				echo "<img src='$pic' alt='$name'/>";
				echo "<br>";
				echo "</td>";	
			}
			// End initial row
			echo "</tr>";
			
			// Create an array to store attributes
			$attributes = array();
			for($i = 0; $i < count($productList) + 1; $i++)
			{
				// Add attributes to the array for each phone
				$attributes[$i] = array();
				$phoneAttributes = $this->loadProductAttrByID($productList[$i]);
				
				// If the attribute array was just made, instead, insert the names
				// of each attribute
				if ($i == 0)
				{
					while($row = mysql_fetch_assoc($phoneAttributes))
						$attributes[$i][] = $row['Name'];
				}
				else
				{
					while($row = mysql_fetch_assoc($phoneAttributes))
						$attributes[$i][] = $row['value'];
				}
			}
			
			// Echo every attribute value for every phone into a table row
			for($i = 0; $i < count($attributes[0]); $i++)
			{
				echo "<tr>";
				for ($j = 0; $j < count($attributes); $j++)
				{
					echo "<td class='phonetable'>";
					echo $attributes[$j][$i];
					echo "</td>";
				}
				echo "</tr>";
			}
			
			// End table
			echo "</table>";
		}
		
		// Returns a list table of product attributes from an array of product ids as a string
		public function getProductAttributeListString($productList)
		{
			$table;
			// Begin table
			$table .= "<table border='1'>";
			
			// Begin initial row
			$table .= "<tr>";
			$table .= "<td>Features</td>";
			// Concatenate the name and picture of each phone in a table cell
			for($i = 0; $i < count($productList); $i++)
			{
				$phoneHeader = mysql_fetch_assoc($this->loadProductByID($productList[$i]));
				
				$name = $phoneHeader["name"];
				$pic = $phoneHeader["pictureURL"];
				
				$table .= "<td>";
				$table .= "$name";
				$table .= "<br>";
				$table .= "<img src='$pic' alt='$name'/>";
				$table .= "<br>";
				$table .= "</td>";	
			}
			// End initial row
			$table .= "</tr>";
			
			// Create an array to store attributes
			$attributes = array();
			for($i = 0; $i < count($productList) + 1; $i++)
			{
				// Add attributes to the array for each phone
				$attributes[$i] = array();
				$phoneAttributes = $this->loadProductAttrByID($productList[$i]);
				
				// If the attribute array was just made, instead, insert the names
				// of each attribute
				if ($i == 0)
				{
					while($row = mysql_fetch_assoc($phoneAttributes))
						$attributes[$i][] = $row['Name'];
				}
				else
				{
					while($row = mysql_fetch_assoc($phoneAttributes))
						$attributes[$i][] = $row['value'];
				}
			}
			
			// Concatenate every attribute value for every phone into a table row
			for($i = 0; $i < count($attributes[0]); $i++)
			{
				$table .= "<tr>";
				for ($j = 0; $j < count($attributes); $j++)
				{
					$table .= "<td>";
					$table .= $attributes[$j][$i];
					$table .= "</td>";
				}
				$table .= "</tr>";
			}
			
			// End table
			$table .= "</table>";
			
			return $table;
		}
	}
?>