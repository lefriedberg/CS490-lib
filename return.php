<html>
<head>
	<title>Library Database System</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>

 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Home</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="loan.html"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>
            <li><a href="addbook.html"><span class="glyphicon glyphicon-book" aria-hidden="true"></span></a></li>
			<li><a href="addmember.html"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
			<li><a href="booksearch.html"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span></a></li>
			<li><a href="membersearch.html"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
			<li><a href="return.html"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></a></li>
			<li><a href="report.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="container theme-showcase" role="main">
		<div class="jumbotron">
		

<?php
	if($_POST['submit'] == "Submit") {
		
		$errorMessage = "";

		$varMid = $_POST['memberid'];
		$varBid = $_POST['bookid'];

		if(empty($varMid)) {
			$errorMessage .= "Member ID";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the member ID!";
  			echo "</div>";
		}
		if(empty($varBid)) {
			$errorMessage .= "Book ID";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the book ID!";
  			echo "</div>";
		}
		
		if(empty($errorMessage)) {
			$db = mysql_connect("localhost","root","");
			
			if(!$db) die("Error connecting to MySQL database.");
			mysql_select_db("library" ,$db);
			
			$dueQuery = mysql_query("SELECT due_date FROM loan WHERE mID='" . $varMid . "' AND bID='" . $varBid . "'");
			$row = mysql_fetch_array($dueQuery);
			$dueDate = $row['due_date'];

			echo "<div class='alert alert-success' role='alert'>";
			echo "<span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Success</span>";
  			echo " Book returned!";
  			echo "</div>";

			$diffQuery = mysql_query("SELECT DATEDIFF(CURDATE(),'" . $dueDate . "') AS datediff");
			$row = mysql_fetch_array($diffQuery);
			$dateDiff = $row['datediff'];
			$fine = intval($dateDiff);

			if($fine > 0) {
				echo("<p>Fine: ".$fine . "</p>");
				echo("</br>");
				$fineQuery = mysql_query("UPDATE member SET debt=debt+".$fine." WHERE ID=" . PrepSQL($varMid));
			}
            
            mysql_query("UPDATE book SET shelf_status = 0 WHERE ID = " . PrepSQL($varBid));
            
			$sql = "DELETE FROM loan WHERE mID=".
			PrepSQL($varMid) . " AND bID=" . 
			PrepSQL($varBid);
			mysql_query($sql);

			$return = mysql_query("SELECT debt FROM member WHERE ID=" . $varMid);
			$row = mysql_fetch_array($return);
			echo("<p>Debt: " . $row['debt'] . "</p>");

			echo("</br>");

			echo "<a href='return.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Submit Another Entry</a>";

			exit();
		} else {
			echo "<a href='return.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Try Again</a>";
		}

	}
	
	// function: PrepSQL()
	// use stripslashes and mysql_real_escape_string PHP functions
	// to sanitize a string for use in an SQL query
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