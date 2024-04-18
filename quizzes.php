<?php
session_start();
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
        <form id="quiz-form" method="post">
            <?php if (empty($questions)) { echo "No questions found for the selected subject."; } else { foreach ($questions as $question): ?>
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
            <?php endforeach; } ?>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
        <div id="result-container" style="display: none;">
            <h2>Quiz Results</h2>
            <p>Your score: <span id="score"></span> out of <span id="total"></span></p>
            <p>Percentage: <span id="percentage"></span>%</p>
        </div>
    </div>
    <script>
    document.getElementById('quiz-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        let score = 0;
        let totalMarks = 0;
        const form = event.target;
        const formData = new FormData(form);
        
        // Loop over questions array to retrieve correct answers
        <?php foreach ($questions as $question): ?>
            const correctAnswer<?php echo $question['id']; ?> = '<?php echo $question['correct_answer']; ?>';
        <?php endforeach; ?>
        
        for (const [key, value] of formData.entries()) {
            totalMarks += 4;
            
            // Retrieve correct answer for the current question
            const correctAnswer = correctAnswer[key];
            
            // Check if selected answer matches the correct answer
            if (value === correctAnswer) {
                score += 4;
            }
            console.log(score, totalMarks);
        }
        const percentage = (score / totalMarks) * 100;
        document.getElementById('score').textContent = score;
        document.getElementById('total').textContent = totalMarks;
        document.getElementById('percentage').textContent = percentage.toFixed(2);
        document.getElementById('result-container').style.display = 'block';

        // Save the results to the database
        fetch('save_results.php', {
            method: 'POST',
            headers: {  
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: '<?php echo $_SESSION["user_id"]; ?>',
                score: score,
                total_marks: totalMarks,
                percentage: percentage.toFixed(2)
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Results saved:', data);
        })
        .catch(error => {
            console.error('Error saving results:', error);
        });
    });
</script>

</body>
</html>