<?php
session_start();
include("./config/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $score = $_POST["score"];
    $total_marks = $_POST["total_marks"];
    $percentage = $_POST["percentage"];

    $sql = "INSERT INTO user_quiz_results (user_id, score, total_marks, percentage, completed_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iids", $user_id, $score, $total_marks, $percentage);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["message" => "Results saved successfully"]);
    } else {
        echo json_encode(["error" => "Error saving results: " . mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>