<?php
include 'includes/functions.php';
checkLoggedIn();
include 'includes/db_connect.php';

// Fetch user data
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = htmlspecialchars($user['username']);

// Fetch recent activities
$sql = "SELECT a.date, at.name as activity_type, a.duration_minutes
        FROM activities a
        JOIN activity_types at ON a.activity_type_id = at.id
        WHERE a.user_id = ?
        ORDER BY a.date DESC
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$recentActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitFlow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <h3>Recent Activities</h3>
        <?php if (empty($recentActivities)): ?>
            <p>You haven't logged any activities yet. <a href="log_activity.php">Log your first workout!</a></p>
        <?php else: ?>
            <ul>
                <?php foreach ($recentActivities as $activity): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($activity['activity_type']); ?></strong> 
                        on <?php echo htmlspecialchars($activity['date']); ?> 
                        for <?php echo htmlspecialchars($activity['duration_minutes']); ?> minutes.
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="log_activity.php" class="button">Log a New Activity</a>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>