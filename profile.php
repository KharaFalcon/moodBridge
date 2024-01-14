<?php
function getProfileUserInfo($pdo, $userID)
{
    $query = "SELECT * FROM users WHERE id = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the user data as an associative array
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userData;
}
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('login/functions/db.php');
include('login/functions/functions.php');

$userID = $_SESSION['UserID'];

// Get user information using the function
$userData = getProfileUserInfo($pdo, $userID);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script src="script.js" defer></script>
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

    <div class="profile">
        <h1>My Profile</h1>
        <div class="image-container">
            <img src="profileImg.png" alt="Profile Picture" id="yourImg" style="width: 200px">
            <h2 class="andSign">&</h2>
            <img src="profileImg.png" alt="Profile Picture" id="partnerImg" style="width: 200px">
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