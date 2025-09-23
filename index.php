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

    <main class="hero-section">
        <div class="hero-content">
            <h1>Start Your Fitness Journey Today</h1>
            <p>Log your workouts, track your progress, and achieve your goals with FitFlow.</p>
            <div class="cta-buttons">
                <a href="register.php" class="button primary">Get Started</a>
                <a href="login.php" class="button secondary">Log In</a>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>