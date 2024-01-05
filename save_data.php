<?php
include('connection.php');

if (isset($_POST["emotions"]) && isset($_POST["activities"])) {
    // Assuming you have a MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "moodEmotions";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the emotions and activities data from the AJAX request
    $emotionsData = $_POST['emotions'];
    $activitiesData = $_POST['activities'];

    // Convert the JSON data to arrays
    $emotionsArray = json_decode($emotionsData, true);
    $activitiesArray = json_decode($activitiesData, true);

    // Insert emotions data into the database
    $emotionsQuery = "INSERT INTO emotions_table (emotion_id) VALUES ";
    foreach ($emotionsArray as $emotionId) {
        $emotionsQuery .= "('$emotionId'), ";
    }
    $emotionsQuery = rtrim($emotionsQuery, ', '); // Remove the trailing comma
    $conn->query($emotionsQuery);

    // Insert activities data into the database
    $activitiesQuery = "INSERT INTO activities_table (activity_id) VALUES ";
    foreach ($activitiesArray as $activityId) {
        $activitiesQuery .= "('$activityId'), ";
    }
    $activitiesQuery = rtrim($activitiesQuery, ', '); // Remove the trailing comma
    $conn->query($activitiesQuery);

    // Close the database connection
    $conn->close();
}
