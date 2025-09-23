<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // If logged in, redirect to the dashboard
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFlow: Your Personal Fitness Journey</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <h2>Welcome to FitFlow!</h2>
        <p>Your journey to a healthier lifestyle starts here. Log in or register to get started.</p>
        <a href="login.php" class="button">Login</a>
        <a href="register.php" class="button">Register</a>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>