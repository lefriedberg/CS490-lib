<?php
	if($_POST['submit'] == "Submit") {
		
		$errorMessage = "";

		$varFName = $_POST['fname'];
		$varLName = $_POST['lname'];
		$varBranch = $_POST['branch'];
		$varYear = $_POST['year'];
		$varSemester = $_POST['semester'];
		$varBDate = $_POST['bdate'];
		$varBMonth = $_POST['bmonth'];
		$varBYear = $_POST['byear'];
		$varAddress = $_POST['address'];

		if(empty($varFName) || empty($varLName)) {
			$errorMessage .= "<li>Enter name</li>";
		}
		if(empty($varBranch)) {
			$errorMessage .= "<li>Select branch</li>";
		}
		if(empty($varYear) || empty($varSemester)) {
			$errorMessage .= "<li>Select year and semester</li>";
		}
		if(empty($varBDate) || empty($varBMonth) || empty($varBYear)) {
			$errorMessage .= "<li>Enter date of birth</li>";
		}
		if(empty($varAddress)) {
			$errorMessage .= "<li>Enter address</li>";
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