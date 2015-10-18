<?php
	if($_POST['submit'] == "Submit") {
		
		$errorMessage = "";

		$varMid = $_POST['memberid'];
		$varBid = $_POST['bookid'];

		if(empty($varMid)) {
			$errorMessage .= "<li>Enter Member ID</li>";
		}
		if(empty($varBid)) {
			$errorMessage .= "<li>Enter Book ID</li>";
		}
		
		if(empty($errorMessage)) {
			$db = mysql_connect("localhost","root","");
			
			if(!$db) die("Error connecting to MySQL database.");
			mysql_select_db("library" ,$db);
			
			$sql = "INSERT INTO loan (mID, bID, due_date) VALUES (".
			PrepSQL($varMid) . ", " . 
			PrepSQL($varBid) . ", " .
			"DATE_ADD(CURDATE(),INTERVAL 2 WEEK) )"; 
			mysql_query($sql);

			$return = mysql_query("SELECT * FROM loan WHERE mID='" . $varMid . "' AND bID='" . $varBid . "'");
			$row = mysql_fetch_array($return);
			echo("Due Date: " . $row['due_date']);

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