<?php
$server     = "localhost";
$username   = "root";
$password   = "root";
$db         = "moodEmotions";

//Create a connection
$conn = mysqli_connect($server, $username, $password, $db);


// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Connected sucessfully!";
