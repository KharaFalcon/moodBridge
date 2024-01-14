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

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script src="script.js" defer></script>
    <script src="settings.js" defer></script>
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
                <li><a href="#">
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
                <li><a href="login/logout.php">
                        <i class="fa-solid fa-chart-pie"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <div class="active"></div>
            </ul>
        </div>
    </div>
    <h1>Settings</h1>
    <div class="containerSettings">
        <div class="subSettings">
            <h2 class="generalTitle">GENERAL</h2>
            <button class="tablink" onclick="openPage('Account', this, '#fea64d')" id="defaultOpen">Account</button>
            <button class="tablink" onclick="openPage('Permissions', this, '#fea64d')">Users and permissions</button>
            <button class="tablink" onclick="openPage('Appearance', this, '#fea64d')">Appearance</button>

        </div>

        <div id="Account" class="tabcontent">
            <h3>Account</h3>
            <div class="avatar-container">
                <img src="avatar.png" alt="Avatar" class="avatar">
                <button class="updateAvatar" onclick="">Update Avatar</button>
            </div>

            <div class="userDetails">
                <form action="process_form.php" method="post">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstNameUp" name="firstName" placeholder="<?php echo $userDetails['FirstName']; ?>" required>

                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastNameUp" name="lastName" placeholder="<?php echo $userDetails['LastName']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="emailUp" name="email" placeholder="<?php echo $userDetails['Email']; ?>" required>

                    <label for="username">Username:</label>
                    <input type="text" id="usernameUp" name="username" placeholder="<?php echo $userDetails['Username']; ?>" required>

                    <button class="updateAvatar" type="submit">Update Account</button>

                </form>
            </div>
        </div>





        <div id="Permissions" class="tabcontent">
            <h3>Users and Permissions</h3>
            <p>Some news this fine day!</p>
        </div>






        <div id="Appearance" class="tabcontent">
            <h3>Appearance</h3>
            <p>Get in touch, or swing by for a cup of coffee.</p>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>