<?php include("./config/db_connect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brainy-Bridges</title>
  <link rel="stylesheet" type="text/css" href="./public/css/quiz.css">
  <style>
    /* Your CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: rgba(255, 216, 186, 1);
    }
    header {
      background-color: rgba(149, 47, 100, 0.8);
      color: white;
      padding: 20px;
      text-align: center;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-evenly;
      padding: 20px;
    }
    .subject {
      background-color: #f2f2f2;
      border-radius: 10px;
      padding: 20px;
      margin: 10px;
      flex: 1 1 300px;
      max-width: 300px;
      text-align: center;
    }
  </style>
</head>
<body>
  <header>
    <h1>Welcome to Brainy-Bridges</h1>
  </header>
  <h2>Select Subject</h2>
  <div class="container">
    <?php
    // Fetch subjects from the SQL table
    $sql = "SELECT * FROM subjects";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
        $subject_id = $row["id"];
        $subject_name = $row["name"];
        // Generate HTML for each subject dynamically
        echo "<div class='subject' id='$subject_name'>";
        echo "<h3>$subject_name (Endterm Quiz)</h3>";
        echo "<p>Explore the endterm quiz for $subject_name.</p>";
        echo "<button onclick=\"window.location.href='quizzes.php?subject=$subject_id'\">Start Quiz</button>";
        echo "</div>";
      }
    } else {
      echo "0 results";
    }
    ?>
  </div>
</body>
</html>