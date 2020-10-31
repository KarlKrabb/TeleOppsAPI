<?php
    require_once "sql/dbconnect.php";
        
    try {
        echo "Test";
        $userValid = false;
        $queryString = "SELECT * FROM TeleUsers WHERE UserEmail='karlk@gmail.com' AND UserPassword='123' ";
        if($result = $mysqli->query($queryString))
        {
            $rows = $result->num_rows;
            // echo("Rows: " . $rows);
            
            $result->free_result();
            if ($rows > 0) {
                $userValid = true;
                echo("Valid: " + $userValid);
            }
        };    
    } catch (Exception $e) {
        echo $e.getMessage();
    }
?>