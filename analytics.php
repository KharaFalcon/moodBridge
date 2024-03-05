<?php include("login/functions/db.php"); ?>

<?php

// Assuming you have a MySQL database
$username = "root";
$password = "root";
$database = "moodBridge";

session_start();

if (!isset($_SESSION['UserID'])) {
  header("Location: login/login.php");
  exit();
}
$currentUserId = $_SESSION['UserID'];

try {
  $pdo = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Error: Could not connect. " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  <script src="js/script.js" defer></script>
  <script src="js/analytics.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Analytics</title>
</head>

<body>
  <div class="header">
    <!-- Your navigation code here -->
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
    <div class="chart-container">
      <h1>Analytics</h1>

      <?php
      try {
        $sql = "SELECT EmotionID, EmotionType FROM moodBridge.Emotions WHERE UserId = " . $currentUserId;

        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
          $emotionLabels = array();
          while ($row = $result->fetch()) {
            $EmotionID = $row['EmotionID'];
            $EmotionName = $row['EmotionType'];
            $emotionLabels[$EmotionID] = $EmotionName;
          }
          unset($result);

          // Count the frequency of each emotion
          $sql = "SELECT EmotionID FROM moodBridge.Emotions WHERE UserId = " . $currentUserId;
          $result = $pdo->query($sql);
          $EmotionID = array();
          while ($row = $result->fetch()) {
            $EmotionID[] = $row['EmotionID'];
          }
          unset($result);
          // Fetch the frequency of each emotion
          $emotionFrequency = array_count_values($EmotionID);

          // Sort emotions by frequency in descending order
          arsort($emotionFrequency);

          // Fetch the top three most frequent emotion IDs
          $topThreeEmotionIDs = array_keys($emotionFrequency);
          $topThreeEmotionIDs = array_slice($topThreeEmotionIDs, 0, 3);

          // Get the corresponding emotion names for the top three IDs
          $topThreeEmotions = array();
          foreach ($topThreeEmotionIDs as $emotionID) {
            $topThreeEmotions[$emotionID] = $emotionLabels[$emotionID];
          }
        }
      } catch (PDOException $e) {
        die("ERROR: Could not be able to execute $sql. " . $e->getMessage());
      }
      ?>

      <?php
      // Fetch data from the database
      try {
        $sql_activities = "SELECT ActivityType, COUNT(*) AS count FROM activities GROUP BY ActivityType";
        $stmt_activities = $pdo->query($sql_activities);
        $activities_data = $stmt_activities->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        die("ERROR: Could not be able to execute $sql_activities. " . $e->getMessage());
      }
      ?>

      <div class="chartBox">
        <canvas id="myChart"></canvas>
      </div>
      <div class="bottomAnalytics">

        <div class="topMoodsContainer">
          <h3 id="topMoodText">Top moods</h3>
          <div class="topMoods">
            <?php $counter = 1; ?>
            <?php foreach ($topThreeEmotions as $EmotionID => $EmotionName) : ?>
              <div id="topMood<?php echo $counter; ?>" class="topMoodGroup <?php echo $class; ?>">
                <h4>#<?php echo $counter; ?></h4>
                <h3>Rank</h3>
                <h2><?php echo $EmotionName; ?></h2>
              </div>
              <?php $counter++; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="pieBackground">
          <h2 id="pieText">What is affecting you the most?</h2>
          <canvas id="pieActivityChart"></canvas>
        </div>
      </div>
      <script>
        const preDefinedLabels = [
          'Enraged ', 'Stressed ', 'Shocked ', 'Fuming ', 'Angry ', 'Restless ', 'Repulsed ', 'Worried ', 'Uneasy ',
          'Disgusted', 'Down', 'Apathetic', 'Miserable', 'Lonely', 'Tired', 'Despair', 'Desolate', 'Drained',
          'Surprised', 'Festive', 'Ecstatic', 'Energized', 'Optimistic', 'Excited', 'Pleasant', 'Hopeful', 'Blissful',
          'At ease', 'Content', 'Fulfilled', 'Relaxed', 'Restful', 'Balanced', 'Sleepy', 'Tranquil', 'Serene'
        ];

        const emotionLabels = <?php echo json_encode($emotionLabels); ?>;
        const emotionData = <?php echo json_encode(array_values($emotionFrequency)); ?>;

        const data = {
          labels: Object.values(emotionLabels),
          datasets: [{
            label: 'Frequency of emotion',
            data: Object.values(emotionData),
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
              'rgb(201, 203, 207)'
            ],
            borderWidth: 1
          }]
        };

        const config = {
          type: 'bar',
          data,
          options: {
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1, // Sets the step size to 1 to display only whole numbers
                  precision: 0 // Hides decimal places
                }
              }
            }
          }
        };

        // Prepare data for the doughnut chart
        const activitiesData = <?php echo json_encode($activities_data); ?>;

        // Extract labels and data from fetched data
        const activityLabels = activitiesData.map(item => item.ActivityType);
        const activityCounts = activitiesData.map(item => item.count);

        // Doughnut chart configuration
        const doughnutConfig = {
          type: 'doughnut',
          data: {
            labels: activityLabels,
            datasets: [{
              data: activityCounts,
              backgroundColor: [
                '#ffa64d',
                '#ff99b3',
                '#ff7f7f',
                '#b3ff99',
                '#ffcc00',
                '#ffdab9',
                '#e6e6fa',
                '#ff7f50',
                '#add8e6'


              ],
            }],
          },
          options: {
            responsive: false,
            maintainAspectRatio: false,
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 12
              }
            }
          }
        };

        // Initialize the doughnut chart
        var ctx_2 = document.getElementById("pieActivityChart").getContext('2d');
        var myDoughnutChart_2 = new Chart(ctx_2, doughnutConfig);


        const myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
      </script>

      <!-- Bootstrap JS -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>