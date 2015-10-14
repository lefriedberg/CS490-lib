<?php
    
    if($_POST["submit"] == "Submit") {
        
        $errorMessage = "";

		$varTitle = $_POST['title'];
		$varAuthor = $_POST['author'];
		$varISBN = $_POST['ISBN'];
		$varCall_no = $_POST['call_no'];
          
        $sql = "SELECT * FROM book WHERE";
        $rql = "";
        if(strcmp($varTitle, "") != 0) {
            $rql .= "title = " . PrepSQL($varTitle) . " , ";
        }
        if(strcmp($varAuthor, "") != 0) {
            $rql .= "author = " . PrepSQL($varAuthor) . " , ";
        }
        if(strcmp($varISBN, "") != 0) {
            $rql .= "ISBN = " . PrepSQL($varISBN) . " , ";
        }
        if(strcmp($varCall_no, "") != 0) {
            $rql .= "call_no = " . PrepSQL($varCall_no) . " , ";
        }
            
        if(empty($rql)){
            $errorMessage = "Enter search terms!"   
        }
            
          $rql = substr($rql, 0 , -2); //now we have a good query!
          $sql .= rql;
          
        echo('<html>
        <head></head>
        <body>');
        
        if(empty($errorMessage)) 
        {
            $db = mysql_connect("localhost","root","");

            if(!$db) die("Error connecting to MySQL database.");
            mysql_select_db("CSC490" ,$db);

            mysql_query($sql);
            
            echo($sql);
            
            //echo the whole table
            $query="SELECT * FROM studentinfo";$result=mysql_query($query);
            $num=mysql_numrows($result);
            echo "<table border = 1>";
            while($row= mysql_fetch_array($result))
                      echo("<tr><td>".$row['id']."</td><td>".
                           $row['firstname']."</td><td>".
                           $row['lastname']."</td><td>".
                           $row['branch']."</td><td>".
                           $row['year']."</td></tr>");
                  
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