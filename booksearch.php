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
    
    if($_POST["submit"] == "Submit") {
        
        $errorMessage = "";

		$varTitle = $_POST['title'];
		$varAuthor = $_POST['author'];
		$varISBN = $_POST['ISBN'];
		$varCall_no = $_POST['callno'];
          
        $sql = "SELECT * FROM book WHERE ";
        $rql = "";
        if(strcmp($varTitle, "") != 0) {
            $rql .= "title = " . PrepSQL($varTitle) . " AND ";
        }
        if(strcmp($varAuthor, "") != 0) {
            $rql .= "author = " . PrepSQL($varAuthor) . " AND ";
        }
        if(strcmp($varISBN, "") != 0) {
            $rql .= "ISBN = " . PrepSQL($varISBN) . " AND ";
        }
        if(strcmp($varCall_no, "") != 0) {
            $rql .= "call_no = " . PrepSQL($varCall_no) . " AND ";
        }
            
        if(empty($rql)) {
            $errorMessage = "Enter search terms!";
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
            echo "<span class='sr-only'>Error:</span>";
            echo " You forgot to enter the search terms!";
            echo "</div>";
        }
            
        $rql = substr($rql, 0 , -5); //now we have a good query!
        $sql .= $rql;
        

        echo('<html>
        <head></head>
        <body>');
        
        if(empty($errorMessage)) {
            $db = mysql_connect("localhost","root","");

            if(!$db) die("Error connecting to MySQL database.");
            mysql_select_db("library" ,$db);

            $result = mysql_query($sql);
            
            echo "<div class='alert alert-success' role='alert'>";
            echo "<span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>";
            echo "<span class='sr-only'>Success</span>";
            echo " Book found!";
            echo "</div>";  



            echo "<table class='table table-striped'>";
            while($row= mysql_fetch_array($result))
                      echo("<tr><td>ID</td><td>Title</td><td>Author</td><td>ISBN</td><td>Call No</td><td>Shelf Status</td></tr><tr><td>".
                            $row['ID']."</td><td>".
                            $row['title']."</td><td>".
                            $row['author']."</td><td>".
                            $row['ISBN']."</td><td>".
                            $row['call_no']."</td><td>".
                            $row['shelf_status']."</td></tr>");
                  
            echo "</table>";
           
            echo "<a href='booksearch.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Submit Another Entry</a>";
        exit();
        }
        else {
            echo "<a href='booksearch.html' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Try Again</a>";
        } 
    }


    function PrepSQL($value)
    {
    // Stripslashes
        if(get_magic_quotes_gpc()) 
        {
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