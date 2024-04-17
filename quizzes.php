<?php
include("./config/db_connect.php");

$subject_id = isset($_GET['subject']) ? $_GET['subject'] : null;

if ($subject_id !== null) {
    // Fetch questions for the selected subject
    $sql = "SELECT * FROM questions WHERE subject_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $questions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $questions = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    $total_marks = 0;
    foreach ($questions as $question) {
        $user_answer = $_POST[$question['id']];
        if ($user_answer == $question['correct_answer']) {
            $score += 4; // Each question is worth 4 marks
        }
        $total_marks += 4; // Each question is worth 4 marks
    }

    // Store the results in the session
    $_SESSION['quiz_score'] = $score;
    $_SESSION['quiz_total'] = $total_marks;

    // Redirect to the result page
    header("Location: result.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./public/css/quiz.css">
  <title>Quiz</title>
</head>
<body>
  <div class="quiz-container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <?php
      if (empty($questions)) {
          echo "No questions found for the selected subject.";
      } else {
          foreach ($questions as $question): ?>
          <div class="question-container">
            <h2 class="question"><?php echo htmlspecialchars($question['question_text']); ?></h2>
            <ul class="options">
              <li>
                <input type="radio" name="<?php echo $question['id']; ?>" value="1">
                <?php echo htmlspecialchars($question['option1']); ?>
              </li>
              <li>
                <input type="radio" name="<?php echo $question['id']; ?>" value="2">
                <?php echo htmlspecialchars($question['option2']); ?>
              </li>
              <li>
                <input type="radio" name="<?php echo $question['id']; ?>" value="3">
                <?php echo htmlspecialchars($question['option3']); ?>
              </li>
              <li>
                <input type="radio" name="<?php echo $question['id']; ?>" value="4">
                <?php echo htmlspecialchars($question['option4']); ?>
              </li>
            </ul>
          </div>
          <?php endforeach;
      }
      ?>
      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
</body>
</html>