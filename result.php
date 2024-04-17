<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];
    $total_marks = $_POST['total_marks'];
    $percentage = $_POST['percentage'];
} else {
    $subject_id = isset($_GET['subject']) ? $_GET['subject'] : null;
    $score = null;
    $total_marks = null;
    $percentage = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./public/css/quiz.css">
    <title>Quiz Results</title>
</head>
<body>
    <div class="quiz-container">
        <h1>Quiz Results</h1>
        <?php if ($score !== null && $total_marks !== null && $percentage !== null) { ?>
            <p>Your score: <?php echo $score; ?> out of <?php echo $total_marks; ?></p>
            <p>Percentage: <?php echo $percentage; ?>%</p>
        <?php } else { ?>
            <p>No quiz results available.</p>
        <?php } ?>
        <a href="quizzes.php?subject=<?php echo $subject_id; ?>">Back to Quiz</a>
    </div>
</body>
</html>