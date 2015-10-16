<?php
    
    if($_POST["submit"] == "Submit") {
        
        $errorMessage = "";

		$varName = $_POST['name'];

        if(empty($varName)) {
            $errorMessage .= "<li>Enter name</li>";
        }
          
        echo('<html>
        <head></head>
        <body>');
        
        if(empty($errorMessage)) {
            $db = mysql_connect("localhost","root","");

            if(!$db) die("Error connecting to MySQL database.");
            mysql_select_db("library" ,$db);

            $result = mysql_query("SELECT * FROM member WHERE name=" . PrepSQL($varName));
            
            echo "<table border = 1>";
            while($row = mysql_fetch_array($result))
                      echo("<tr><td>ID</td><td>Name</td><td>Debt</td></tr><tr><td>".
                           $row['ID']."</td><td>".
                           $row['name']."</td><td>".
                           $row['debt']."</td></tr>");
                  
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