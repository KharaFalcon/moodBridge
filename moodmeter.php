<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodFlag</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script src="script.js" defer></script>

</head>

<body>
    <div class="header">
        <div class="side-nav">
            <ul class="nav-links">
                <li><a href="moodmeter.html">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p>Mood Meter</p>
                    </a>
                </li>
                <li><a href="#">
                        <i class="fa-solid fa-user"></i>
                        <p>Analytics</p>
                    </a>
                </li>
                <li><a href="profile.html">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li><a href="php/settings.php">
                        <i class="fa-solid fa-chart-pie"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <div class="active"></div>
            </ul>
        </div>
    </div>

    <h2 id="welcomeMsg"><?php echo $_SESSION['username']; ?>, How are you doing?</h2>
    <p id="date-container"></p>

    <div class="container">
        <div class="dot" draggable="true"><span>Emotion Pin</span></div>
        <div class="moodBoard">
            <div class="cell darkRed" id="Enraged">Enraged</div>
            <div class="cell mediumRed" id="Stressed">Stressed</div>
            <div class="cell lightRed" id="Shocked">Shocked</div>
            <div class="cell darkOrange" id="Surprised">Surprised</div>
            <div class="cell mediumOrange" id="Festive">Festive</div>
            <div class="cell lightOrange" id="Ecstatic">Ecstatic</div>

            <div class="cell darkRed" id="Fuming">Fuming</div>
            <div class="cell mediumRed" id="Angry">Angry</div>
            <div class="cell lightRed" id="Restless">Restless</div>
            <div class="cell darkOrange" id="Energized">Energized</div>
            <div class="cell mediumOrange" id="Optimistic">Optimistic</div>
            <div class="cell lightOrange" id="Excited">Excited</div>

            <div class="cell darkRed" id="Repulsed">Repulsed</div>
            <div class="cell mediumRed" id="Worried">Worried</div>
            <div class="cell lightRed" id="Uneasy">Uneasy</div>
            <div class="cell darkOrange" id="Pleasant">Pleasant</div>
            <div class="cell mediumOrange" id="Hopeful">Hopeful</div>
            <div class="cell lightOrange" id="Blissful">Blissful</div>

            <div class="cell darkBlue" id="Disgusted">Disgusted</div>
            <div class="cell mediumBlue" id="Down">Down</div>
            <div class="cell lightBlue" id="Apathetic">Apathetic</div>
            <div class="cell darkGreen" id="At ease">At ease</div>
            <div class="cell mediumGreen" id="Content">Content</div>
            <div class="cell lightGreen" id="Fulfilled">Fulfilled</div>

            <div class="cell darkBlue" id="Miserable">Miserable</div>
            <div class="cell mediumBlue" id="Lonely">Lonely</div>
            <div class="cell lightBlue" id="Tired">Tired</div>
            <div class="cell darkGreen" id="Relaxed">Relaxed</div>
            <div class="cell mediumGreen" id="Restful">Restful</div>
            <div class="cell lightGreen" id="Balanced">Balanced</div>

            <div class="cell darkBlue" id="Despair">Despair</div>
            <div class="cell mediumBlue" id="Desolate">Desolate</div>
            <div class="cell lightBlue" id="Drained">Drained</div>
            <div class="cell darkGreen" id="Sleepy">Sleepy</div>
            <div class="cell mediumGreen" id="Tranquil">Tranquil</div>
            <div class="cell lightGreen" id="Serene">Serene</div>

        </div>
        <div class="extra-info">
            <h3>You are feeling.... <span id="selectedEmotion"></span></h3>
            <p>What has affected your mood?</p>
            <div class="eventBtn">
                <input type="button" class="btn" id="Exercise" value="+ Exercise" />
                <input type="button" class="btn" id="Friends" value="+ Friends" />
                <input type="button" class="btn" id="Family" value="+ Family" />
                <input type="button" class="btn" id="Stress" value="+ Stress" />
                <br />
                <input type="button" class="btn" id="Weather" value="+ Weather" />
                <input type="button" class="btn" id="Work" value="+ Work" />
                <input type="button" class="btn" id="Love" value="+ Love" />
                <input type="button" class="btn" id="Sleep" value="+ Sleep" />
                <br />
                <input type="button" class="btn" id="Health" value="+ Health" />
                <input type="button" class="btn" id="Money" value="+ Money" />
                <input type="button" class="btn" id="News" value="+ News" />
                <input type="button" class="btn" id="Holiday" value="+ Holiday" />
                <input type="button" class="btn" id="Food" value="+ Food" />
            </div>
            <form>
                <textarea placeholder="Notes..."></textarea>
                <input type="button" class="saveBtn" id="Food" value="Save" />
            </form>
        </div>
    </div>
</body>

</html>