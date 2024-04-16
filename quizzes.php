<?php
include("./config/db_connect.php");

// Fetch all questions from the database
$sql = "SELECT * FROM questions";
$result = mysqli_query($conn, $sql);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php foreach ($questions as $question): ?>
                <div class="question-container">
                    <h2 class="question">
                        <?php echo htmlspecialchars($question['question_text']); ?>
                    </h2>
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
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>

</html>