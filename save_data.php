<?php
include("includes/functions.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

var_dump($_SESSION);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die('Invalid request method');
}

error_log('User ID in session: ' . $_SESSION['UserID']);

if (!isset($_SESSION['UserID'])) {
    die('Unauthorized access');
}

$emotions = isset($_POST['emotions']) ? json_decode($_POST['emotions'], true) : [];
if ($emotions === null) {
    die('Invalid JSON format');
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "moodBridge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

foreach ($emotions as $emotion) {
    try {
        $insertEmotionQuery = $conn->prepare("INSERT INTO `Emotions` (`EmotionID`, `UserID`, `EmotionType`, `Date`) VALUES (?, ?, ?, NOW())");

        if (!$insertEmotionQuery) {
            throw new Exception('Prepare statement error: ' . $conn->error);
        }

        $insertEmotionQuery->bind_param("sis", $emotion['id'], $_SESSION['UserID'], $emotion['name']);

        if (!$insertEmotionQuery->execute()) {
            throw new Exception('Emotion Insert Error: ' . $insertEmotionQuery->error);
        }

        $insertEmotionQuery->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

$conn->close();

echo 'Data saved successfully';
