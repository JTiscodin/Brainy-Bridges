<?php 

    $conn = mysqli_connect("localhost", "Jatin", "test123", "test"); // Create connection
    
    // Check connection
    if (!$conn) {
        echo "Connection failed: " . mysqli_connect_error();
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo "Hello World" ?>
</body>
</html>