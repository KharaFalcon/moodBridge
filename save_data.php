<?php
include('connection.php');

    // Assuming you have a MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "login_db";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    

    ?>