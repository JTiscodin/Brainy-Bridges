<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./public/css/quiz.css">
  <title>Quiz Result</title>
</head>
<body>
  <div class="quiz-container">
    <h1>Quiz Result</h1>
    <?php
    if (isset($_SESSION['quiz_score']) && isset($_SESSION['quiz_total'])) {
        $score = $_SESSION['quiz_score'];
        $total_marks = $_SESSION['quiz_total'];
        echo "<p>Your score: " . $score . " out of " . $total_marks . "</p>";
        echo "<p>Percentage: " . round(($score / $total_marks) * 100, 2) . "%</p>";
        unset($_SESSION['quiz_score'], $_SESSION['quiz_total']);
    } else {
        echo "<p>No results available.</p>";
    }
    ?>
    <a href="allquizzes.php">Back to Subjects</a>
  </div>
</body>
</html>