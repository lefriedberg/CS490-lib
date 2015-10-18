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
            
            echo "<table border = 1>";
            while($row= mysql_fetch_array($result))
                      echo("<tr><td>ID</td><td>Title</td><td>Author</td><td>ISBN</td><td>Call No</td><td>Shelf Status</td></tr><tr><td>".
                            $row['ID']."</td><td>".
                            $row['title']."</td><td>".
                            $row['author']."</td><td>".
                            $row['ISBN']."</td><td>".
                            $row['call_no']."</td><td>".
                            $row['shelf_status']."</td></tr>");
                  
            echo "</table>";
           // $i=0;while ($i < $num) {
            //    echo implode(" ",mysql_fetch_array($result));
            //    echo "<br>";
              //  $i++;}
            
        //header("thank-you.html");
        exit();
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