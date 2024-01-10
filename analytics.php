<?php include("login/functions/db.php"); ?>

<?php
// Assuming you have a MySQL database
$username = "root";
$password = "root";
$database = "moodBridge";
try {
  $pdo = new PDO("mysql:host=localhost;databse=$database", $username, $password);
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
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <script src="script.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Analytics</title>
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
        <li><a href="analytics.html">
            <i class="fa-solid fa-user"></i>
            <p>Analytics</p>
          </a>
        </li>
        <li><a href="profile.html">
            <i class="fa-solid fa-box-open"></i>
            <p>Profile</p>
          </a>
        </li>
        <li><a href="settings.html">
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
      $sql = "SELECT emotion1 FROM moodBridge.emotions_table";
      $result = $pdo->query($sql);

      if ($result->rowCount() > 0) {
        $emotion1 = array();
        while ($row = $result->fetch()) {
          $emotion1[] = $row['emotion1'];
        }
        unset($result);

        //count the frequency of each emotion
        $emotion1Frequency = array_count_values($emotion1);
      } else {
        echo "No records matching the query were found";
      }
    } catch (PDOException $e) {
      die("ERROR: Could not be able to execute $sql. " . $e->getMessage());

      unset($pdo);
    }

    ?>

    <div class="chartBox">
      <canvas id="myChart"></canvas>
    </div>

    <script>
      //Setup Block 

      const preDefinedLabels = [
        'Enraged ', 'Stressed ', 'Shocked ', 'Fuming ', 'Angry ', 'Restless ', 'Repulsed ', 'Worried ', 'Uneasy ',
        'Disgusted', 'Down', 'Apathetic', 'Miserable', 'Lonely', 'Tired', 'Despair', 'Desolate', 'Drained',
        'Surprised', 'Festive', 'Ecstatc', 'Energized', 'Optimistic', 'Excited', 'Pleasant', 'Hopeful', 'Blissful',
        'At ease', 'Content', 'Fulfilled', 'Relaxed', 'Restful', 'Balanced', 'Sleepy', 'Tranquil', 'Serene'
      ];


      const emotion1Labels = preDefinedLabels;
      const emotion1Data = <?php echo json_encode(array_values($emotion1Frequency)); ?>;

      console.log(<?php echo json_encode($emotion1Frequency); ?>);
      const data = {
        labels: emotion1Labels,
        datasets: [{
          label: 'Frequency of emotion',
          data: Object.values(emotion1Data),
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

      //Config Block
      const config = {
        type: 'bar',
        data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      };


      //Render Block 
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
    </script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>
</body>

</html>