<?php
session_start();
include 'includes/db_connect.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($username) || empty($password) || empty($email)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password, $email]);
            $_SESSION['user_id'] = $conn->lastInsertId();
            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
            $message = "Registration failed. Username or email may already be taken.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FitFlow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2>Register</h2>
        <?php if ($message): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>