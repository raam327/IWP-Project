<?php
session_start();
include 'includes/db_connect.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try {
        $sql = "SELECT id, password_hash FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $message = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitFlow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2>Login</h2>
        <?php if ($message): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>