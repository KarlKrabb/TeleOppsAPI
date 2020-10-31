<?php

    $dbusername = 'root';
    $dbpassword = 'root';
    $dbname = 'TeleOppsDB';
    $dbserver = 'localhost';
    // $port = "8888";

    $mysqli = new mysqli($dbserver,$dbusername,$dbpassword,$dbname);

    if ($mysqli->connect_errno) {
        echo "Sorry, this website is experiencing problems.";            
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";                
        exit;
    }
?>