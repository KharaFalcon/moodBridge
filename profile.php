<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "moodBridge";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login/login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user details from the database using prepared statement
$UserID = $_SESSION['UserID'];
$sql = "SELECT * FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $UserID);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
} else {
    // Handle the case where user details are not found
    echo "Error: Unable to fetch user details.";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['partnerCode'])) {
    $partnerCode = $_POST['partnerCode'];

    // Check if the user already has a partner
    $sql_check_partner = "SELECT PartnerID FROM Users WHERE UserID = ?";
    $stmt_check_partner = $conn->prepare($sql_check_partner);
    $stmt_check_partner->bind_param("i", $UserID);
    $stmt_check_partner->execute();
    $result_check_partner = $stmt_check_partner->get_result();
    $user_partner_id = $result_check_partner->fetch_assoc()['PartnerID'];

    if ($user_partner_id) {
        echo "You already have a partner.";
        exit();
    }

    // Add the partner code to the PartnerID in the database for the second user
    $sql_update_user_partner = "UPDATE Users SET PartnerID = ? WHERE UserID = ?";
    $stmt_update_user_partner = $conn->prepare($sql_update_user_partner);
    $stmt_update_user_partner->bind_param("ii", $partnerCode, $UserID);

    // Update the partner's PartnerID to match the user's UserID
    $sql_get_partner_id = "SELECT UserID FROM Users WHERE PartnerID = ?";
    $stmt_get_partner_id = $conn->prepare($sql_get_partner_id);
    $stmt_get_partner_id->bind_param("i", $UserID);
    $stmt_get_partner_id->execute();
    $result_partner_id = $stmt_get_partner_id->get_result();
    $partnerData = $result_partner_id->fetch_assoc();
    $partnerID = $partnerData['UserID'];

    $sql_update_partner_partner = "UPDATE Users SET PartnerID = ? WHERE UserID = ?";
    $stmt_update_partner_partner = $conn->prepare($sql_update_partner_partner);
    $stmt_update_partner_partner->bind_param("ii", $UserID, $partnerCode);

    // Execute both statements
    if ($stmt_update_user_partner->execute() && $stmt_update_partner_partner->execute()) {
        echo "Partner added successfully for the second user.";
    } else {
        echo "Error adding partner for the second user.";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <script src="js/script.js" defer></script>
    <script src="js/profile.js" defer></script>
    <title>MoodMeter</title>
</head>

<body>
    <div class="header">
        <div class="side-nav">
            <ul class="nav-links">
                <li><a href="moodmeter.php">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p>MoodBridge</p>
                    </a>
                </li>
                <li><a href="analytics.php">
                        <i class="fa-solid fa-user"></i>
                        <p>Analytics</p>
                    </a>
                </li>
                <li><a href="profile.php">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li><a href="settings.php">
                        <i class="fa-solid fa-chart-pie"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <div class="active"></div>

                <li><a href="login/logout.php">
                        <i class="fa-solid fa-chart-pie"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <div class="active"></div>
            </ul>
        </div>
    </div>
    </div>

    <div class="profile">
        <h1>My Profile</h1>
        <div class="partnerCodeContainer">
            <div id="partnerInputContainer">
                <h3 class="partnerCodeText">To add and connect to a partner enter their code below:</h3>
                <textarea id="partnerCodeInput" name="partnerCode" placeholder="Enter 10 digit code"></textarea>
                <button class="partnerAddBtn">Add</button>
            </div>
            <h4 class="partnerCodeShare">Share this code to connect with a partner:</h4>
            <h4 id="shareId"><?php echo $UserID; ?></h4>
        </div>
        <div class="image-container">
            <img src="img/avatar.png" alt="Profile Picture" id="yourImg" style="width: 200px; border-radius:250px; border: solid grey">
            <h2 class="andSign">&</h2>
            <img src="img/avatar.png" alt="Profile Picture" id="partnerImg" style="width: 200px; border-radius:250px; border:solid grey">
        </div>
        <div class="nameProfile">
            <h3 id="yourName"><?php echo $_SESSION['FirstName']; ?></h3>

        </div>

    <div class="nameProfile">
        <h3 id="pName"><?php echo $partnerName; ?></h3> <!-- Display partner's name -->
    </div>
</body>

</html>