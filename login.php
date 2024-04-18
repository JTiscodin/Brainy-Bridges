<?php
session_start();
include ("./config/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $msg = "Username or email already exists.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: quizzes.php");
            $_SESSION['user_id'] = $email;
            $_SESSION['username'] = $username;
            header("Location: allquizzes.php");
            exit();
        } else {
            $msg = "Error registering user: " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRAINY-BRIDGES</title>
    <link rel="stylesheet" href="./public/css/login.css" />
</head>

<body>
    <div class="container">
        <h1>USER-REGISTRATION</h1>
        <form id="registrationForm" method="post">
            <div class="form-group">
                <label for="username">User Name:</label>
                <input type="text" id="username" name="username" required>
                <span id="fname_error" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="email">Email-id:</label>
                <input type="email" id="email" name="email" required>
                <span id="email_error" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span id="pw_error" class="text-danger"></span>
            </div>
            <div>
                <button type="submit" id="submitBtn">Submit</button>
            </div>
        </form>
    </div>
    <script src="first.js"></script>
</body>

</html>