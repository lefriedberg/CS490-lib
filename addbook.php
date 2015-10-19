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

		$varTitle = $_POST['title'];
		$varAuthor = $_POST['author'];
		$varISBN = $_POST['ISBN'];
		$varCall_no = $_POST['call_no'];
        
        //make sure all fields are complete
		if(empty($varTitle)) {
			$errorMessage .= "Title";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the title!";
  			echo "</div>";

		}
		if(empty($varAuthor)) {
			$errorMessage .= "Author";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the title!";
  			echo "</div>";
		}
		if(empty($varISBN)) {
			$errorMessage .= "ISBN";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the title!";
  			echo "</div>";
		}
		if(empty($varCall_no)) {
			$errorMessage .= "Call_No";
			echo "<div class='alert alert-danger' role='alert'>";
			echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Error:</span>";
  			echo " You forgot to enter the title!";
  			echo "</div>";
		}
		
		if(empty($errorMessage)) {
			$db = mysql_connect("localhost","root",""); //connect to database
			
			if(!$db) die("Error connecting to MySQL database.");
			mysql_select_db("library" ,$db);
			
			$sql = "INSERT INTO book (title, author, ISBN, call_no) VALUES (".
			PrepSQL($varTitle) . ", " .
			PrepSQL($varAuthor) . ", " .
			PrepSQL($varISBN) . ", " .
			PrepSQL($varCall_no) . ")";
			mysql_query($sql);

			$rollno = mysql_query("SELECT ID FROM book ORDER BY id DESC LIMIT 1");
			

			$row = mysql_fetch_array($rollno);
			
			echo "<div class='alert alert-success' role='alert'>";
			echo "<span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>";
			echo "<span class='sr-only'>Success</span>";
  			echo " Book added!";
  			echo "</div>";	

			echo("<p>Book ID: " . $row['ID']. "</p>");
			echo("</br>");

			echo "<a href='addbook.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Submit Another Entry</a>";

			exit();
		} else {
			echo "<a href='addbook.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Try Again</a>";
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

</div>
	</div>
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

