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

        $insertEmotionQuery->bind_param("iss", $emotion['id'], $_SESSION['UserID'], $emotion['name']);

        if (!$insertEmotionQuery->execute()) {
            throw new Exception('Emotion Insert Error: ' . $insertEmotionQuery->error);
        }

        $insertEmotionQuery->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

// Activities

$activities = isset($_POST['activities']) ? json_decode($_POST['activities'], true) : [];
if ($activities === null) {
    die('Invalid JSON format');
}

foreach ($activities as $activity) {
    try {
        $insertActivityQuery = $conn->prepare("INSERT INTO `Activities` (`ActivityID`, `UserID`, `ActivityType`, `Date`) VALUES (?, ?, ?, NOW())");

        if (!$insertActivityQuery) {
            throw new Exception('Prepare statement error: ' . $conn->error);
        }

        $insertActivityQuery->bind_param("iss", $activity['id'], $_SESSION['UserID'], $activity['name']);

        if (!$insertActivityQuery->execute()) {
            throw new Exception('Activity Insert Error: ' . $insertActivityQuery->error);
        }

        $insertActivityQuery->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

// Notes
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

try {
    $insertNotesQuery = $conn->prepare("INSERT INTO `Notes` (`UserID`, `NoteText`, `Date`) VALUES (?, ?, NOW())");

    if (!$insertNotesQuery) {
        throw new Exception('Prepare statement error: ' . $conn->error);
    }

    $insertNotesQuery->bind_param("is", $_SESSION['UserID'], $notes);

    if (!$insertNotesQuery->execute()) {
        throw new Exception('Notes Insert Error: ' . $insertNotesQuery->error);
    }

    $insertNotesQuery->close();
} catch (Exception $e) {
    error_log($e->getMessage());
}

$conn->close();

echo 'Data saved successfully';
