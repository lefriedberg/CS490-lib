<?php
	if($_POST['submit'] == "Submit") {
		
		$errorMessage = "";

		$varTitle = $_POST['title'];
		$varAuthor = $_POST['author'];
		$varISBN = $_POST['ISBN'];
		$varCall_no = $_POST['call_no'];

		if(empty($varTitle) {
			$errorMessage .= "<li>Enter title</li>";
		}
		if(empty($varAuthor)) {
			$errorMessage .= "<li>Enter author</li>";
		}
		if(empty($varISBN) {
			$errorMessage .= "<li>Enter ISBN</li>";
		}
		if(empty($varCall_no)) {
			$errorMessage .= "<li>Enter call number</li>";
		}
		
		if(empty($errorMessage)) {
			$db = mysql_connect("localhost","root","");
			
			if(!$db) die("Error connecting to MySQL database.");
			mysql_select_db("stuinfo" ,$db);
			
			$sql = "INSERT INTO stuinfo (fname, lname, branch, year, semester, dateofbirth, address)\nVALUES (".
			PrepSQL($varFName) . ", " .
			PrepSQL($varLName) . ", " .
			PrepSQL($varBranch) . ", " .
			$varYear . ", " .
			PrepSQL($varSemester) . ", " .
			"'" . $varBYear . "-" . $varBMonth . "-" . $varBDate . "', " .
			PrepSQL($varAddress) . ")";
			mysql_query($sql);

			$rollno = mysql_query("SELECT rollno FROM stuinfo WHERE fname='" . $varFName . "' AND lname='" . $varLName . "'");
			$row = mysql_fetch_array($rollno);
			echo("Roll Number: " . $row['rollno']);

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