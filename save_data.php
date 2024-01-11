<?php include("includes/functions.php") ?>
<?php

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

// Debugging: Output the received data to the error log
error_log('Emotions: ' . print_r($emotions, true));

if (empty($emotions)) {
    die('Invalid input');
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "moodBridge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Insert the selected emotions into the Emotions table
foreach ($emotions as $emotion) {
    // Use prepared statements to prevent SQL injection
    $insertEmotionQuery = $conn->prepare("INSERT INTO `Emotions` (`EmotionID`, `UserID`, `EmotionType`, `Date`) VALUES (?, ?, ?, NOW())");

    // Check for prepared statement errors
    if (!$insertEmotionQuery) {
        error_log('Prepare statement error: ' . $conn->error);
        continue;  // Move on to the next iteration if there's an issue
    }

    $insertEmotionQuery->bind_param("iss", $_SESSION['UserID'], $emotion['id'], $emotion['name']);
    $result = $insertEmotionQuery->execute();

    if (!$result) {
        error_log('Emotion Insert Error: ' . $insertEmotionQuery->error);
    }

    $insertEmotionQuery->close();  // Close the prepared statement after use
}

$conn->close();

echo 'Data saved successfully';
