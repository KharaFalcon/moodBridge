<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodBridge</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <script src="js/script.js" defer></script>

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

                <li><a href="login/logout.php">
                        <i class="fa-solid fa-chart-pie"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <div class="active"></div>
            </ul>
        </div>
    </div>
    <div id=content-container>
        <h2 id="welcomeMsg"><?php echo $_SESSION['username']; ?>, How are you doing today?</h2>
        <p id="date-container"></p>
        <p id="errorMsg"></p>
        <div class="container">
            <div class="dot" draggable="true"><span>Emotion Pin</span></div>
            <div class="moodBoard">
                <div class="cell darkRed" id="1">Enraged</div>
                <div class="cell mediumRed" id="2">Stressed</div>
                <div class="cell lightRed" id="3">Shocked</div>
                <div class="cell darkOrange" id="4">Surprised</div>
                <div class="cell mediumOrange" id="5">Festive</div>
                <div class="cell lightOrange" id="6">Ecstatic</div>

                <div class="cell darkRed" id="7">Fuming</div>
                <div class="cell mediumRed" id="8">Angry</div>
                <div class="cell lightRed" id="9">Restless</div>
                <div class="cell darkOrange" id="10">Energized</div>
                <div class="cell mediumOrange" id="11">Optimistic</div>
                <div class="cell lightOrange" id="12">Excited</div>

                <div class="cell darkRed" id="13">Repulsed</div>
                <div class="cell mediumRed" id="14">Worried</div>
                <div class="cell lightRed" id="15">Uneasy</div>
                <div class="cell darkOrange" id="16">Pleasant</div>
                <div class="cell mediumOrange" id="17">Hopeful</div>
                <div class="cell lightOrange" id="18">Blissful</div>

                <div class="cell darkBlue" id="19">Disgusted</div>
                <div class="cell mediumBlue" id="20">Down</div>
                <div class="cell lightBlue" id="21">Apathetic</div>
                <div class="cell darkGreen" id="22">At ease</div>
                <div class="cell mediumGreen" id="23">Content</div>
                <div class="cell lightGreen" id="24">Fulfilled</div>

                <div class="cell darkBlue" id="25">Miserable</div>
                <div class="cell mediumBlue" id="26">Lonely</div>
                <div class="cell lightBlue" id="27">Tired</div>
                <div class="cell darkGreen" id="28">Relaxed</div>
                <div class="cell mediumGreen" id="29">Restful</div>
                <div class="cell lightGreen" id="30">Balanced</div>

                <div class="cell darkBlue" id="31">Despair</div>
                <div class="cell mediumBlue" id="32">Desolate</div>
                <div class="cell lightBlue" id="33">Drained</div>
                <div class="cell darkGreen" id="34">Sleepy</div>
                <div class="cell mediumGreen" id="35">Tranquil</div>
                <div class="cell lightGreen" id="36">Serene</div>

            </div>
            <div class="extra-info">
                <h3>You are feeling.... <span id="selectedEmotion"></span></h3>
                <p>What has affected your mood?</p>
                <div class="eventBtn">
                    <input type="button" class="btn" id="1" value="Exercise" />
                    <input type="button" class="btn" id="2" value="Friends" />
                    <input type="button" class="btn" id="3" value="Family" />
                    <input type="button" class="btn" id="4" value="Stress" />
                    <br />
                    <input type="button" class="btn" id="5" value="Weather" />
                    <input type="button" class="btn" id="6" value="Work" />
                    <input type="button" class="btn" id="7" value="Love" />
                    <input type="button" class="btn" id="8" value="Sleep" />
                    <br />
                    <input type="button" class="btn" id="9" value="Health" />
                    <input type="button" class="btn" id="10" value="Money" />
                    <input type="button" class="btn" id="11" value="News" />
                    <input type="button" class="btn" id="12" value="Holiday" />
                    <input type="button" class="btn" id="13" value="Food" />
                </div>
                <form>
                    <textarea placeholder="Notes..."></textarea>
                    <p id="errorDayMax"></p>
                </form>
                <input type="button" class="submitBtn" id="submit" value="Submit" />
            </div>
        </div>
    </div>
</body>

</html>