<?php
include("./config/db_connect.php");

$year = $_GET['year'];
$subject = $_GET['subject'];
$quizType = $_GET['quizType'];

$sql = "SELECT * FROM questions WHERE year = ? AND subject = ? AND quiz_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $year, $subject, $quizType);
$stmt->execute();
$result = $stmt->get_result();

$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($questions);