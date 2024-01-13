<?php include("login/functions/db.php"); ?>

<?php
// Assuming you have a MySQL database
$username = "root";
$password = "root";
$database = "moodBridge";
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
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <script src="script.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Analytics</title>
</head>

<body>
  <div class="header">
    <!-- Your navigation code here -->
  </div>
  <div class="chart-container">
    <h1>Analytics</h1>

    <?php
    try {
      $sql = "SELECT EmotionID, EmotionType FROM moodBridge.Emotions";
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
        $sql = "SELECT EmotionID FROM moodBridge.Emotions";
        $result = $pdo->query($sql);
        $EmotionID = array();
        while ($row = $result->fetch()) {
          $EmotionID[] = $row['EmotionID'];
        }
        unset($result);

        $emotionFrequency = array_count_values($EmotionID);
      } else {
        echo "No records matching the query were found";
      }
    } catch (PDOException $e) {
      die("ERROR: Could not be able to execute $sql. " . $e->getMessage());
    }
    ?>

    <div class="chartBox">
      <canvas id="myChart"></canvas>
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
              beginAtZero: true
            }
          }
        }
      };

      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
    </script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>