<?php
    
    if($_POST["update"] == "Submit") {
        $varFirstName = $_POST['firstname'];
        $varLastName = $_POST['lastname'];
        $varBranch = $_POST['branch'];
        $varBday = $_POST['bday'];
        $varYear = $_POST['year'];
        $varAddress = $_POST['address'];
        $varTrimester = $_POST['trimester'];
          
        $sql = "UPDATE studentinfo SET ";
        $errorMessage = "";
        if(empty($_POST['id'])) {
            $errorMessage .= "No id found! <br>";
        }
        if(!empty($_POST['firstname'])) {
            $sql .= "firstname = " .  PrepSQL($varFirstName) . " , ";
        }
        if(!empty($_POST['lastname'])) {
            $sql .= "lastname = " .  PrepSQL($varLastName) . " , ";
        }
        if(!empty($_POST['branch'])) {
            $sql .= "branch = " .  PrepSQL($varBranch) . " , ";
        }
          if(!empty($_POST['bday'])) {
              if(1 == preg_match("/^\d\d\d\d\-[01]\d\-\d\d$/", $varBday)){
                  $sql .= "dateofbirth = " .  PrepSQL($varBday) . " , ";
              }else{
                  $errorMessage .= "Invalid date format <br>";
              }
        }
            if(!empty($_POST['trimester'])) {
            $sql .= "trimester = " .  PrepSQL($varTrimester) . " , ";
        }
          if(!empty($_POST['address'])) {
            $sql .= "address = " .  PrepSQL($varAddress) . " , ";
        }
          if(strcmp($_POST['year'], "") != 0) {
            $sql .= "year = " .  PrepSQL($varYear) . " , ";
        }
          
          $sql = substr($sql, 0 , -2);

          
          $sql .= "WHERE id = " . $_POST['id'];
          
        //now we have a good query!
          
          
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