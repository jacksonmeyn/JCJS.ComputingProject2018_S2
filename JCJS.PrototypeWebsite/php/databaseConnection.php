<?php
    //connect to database
    $servername = $_SERVER['SERVER_NAME'];
    $username = "sdanie16";
    $password = "01051978";
    $dbname = "ppb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
?>