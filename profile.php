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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/.styles.css" />
    <script src="js/script.js" defer></script>
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
        <div class="image-container">
            <img src="img/avatar.png" alt="Profile Picture" id="yourImg" style="width: 200px; border-radius:250px; border: solid grey">
            <h2 class="andSign">&</h2>
            <img src="img/avatar.png" alt="Profile Picture" id="partnerImg" style="width: 200px; border-radius:250px; border:solid grey">
        </div>
        <div class="nameProfile">
            <h3 id="yourName"><?php echo $_SESSION['FirstName']; ?></h3>
            <h3 id="pName">John Doe2</h3>
        </div>
        <div class="info">
            <h1>Information</h1>
            <p>Web Developer</p>
            <ul>
                <li><strong>Email:</strong> johndoe@email.com</li>
                <li><strong>Location:</strong> Anytown, ABC</li>
            </ul>
        </div>
    </div>
</body>

</html>