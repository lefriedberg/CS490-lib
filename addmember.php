<?php
	if($_POST['submit'] == "Submit") {
		
		$errorMessage = "";

		$varName = $_POST['name'];

		if(empty($varName) {
			$errorMessage .= "<li>Enter name</li>";
		}
		
		if(empty($errorMessage)) {
			$db = mysql_connect("localhost","root","");
			
			if(!$db) die("Error connecting to MySQL database.");
			mysql_select_db("library" ,$db);
			
			$sql = "INSERT INTO member (name) VALUES (".
			PrepSQL($varName) . ")";
			mysql_query($sql);

			$memberid = mysql_query("SELECT ID FROM member WHERE name='" . $varName . "'");
			$row = mysql_fetch_array($memberid);
			echo("ID: " . $row['ID']);

			exit();
		} else {
			echo($errorMessage);
		}

	}
	
	// function: PrepSQL()
	// use stripslashes and mysql_real_escape_string PHP functions
	// to sanitize a string for use in an SQL query
	//
	// also puts single quotes around the string
	//
	function PrepSQL($value) {
		// Stripslashes
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		
		// Quote
		$value = "'" . mysql_real_escape_string($value) . "'";
		
		return($value);
	}
?>