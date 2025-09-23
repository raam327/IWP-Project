<?php
include 'includes/functions.php';
checkLoggedIn();
include 'includes/db_connect.php';

$message = '';

// Fetch activity types for the dropdown
$sql = "SELECT id, name FROM activity_types ORDER BY name";
$stmt = $conn->query($sql);
$activityTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $activityTypeId = $_POST['activity_type_id'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $distance = $_POST['distance'] ?? null;
    $sets = $_POST['sets'] ?? null;
    $reps = $_POST['reps'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $notes = htmlspecialchars($_POST['notes'] ?? '');

    try {
        $sql = "INSERT INTO activities (user_id, activity_type_id, date, duration_minutes, distance_km, sets, reps, weight_kg, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $activityTypeId, $date, $duration, $distance, $sets, $reps, $weight, $notes]);
        $message = "Activity logged successfully!";
    } catch (PDOException $e) {
        $message = "Error logging activity: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Activity - FitFlow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2>Log a New Activity</h2>
        <?php if ($message): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="log_activity.php" method="post">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">

            <label for="activity_type_id">Activity Type:</label>
            <select id="activity_type_id" name="activity_type_id" required>
                <?php foreach ($activityTypes as $type): ?>
                    <option value="<?php echo htmlspecialchars($type['id']); ?>"><?php echo htmlspecialchars($type['name']); ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" required>

            <div id="additional-fields">
                </div>

            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes"></textarea>

            <button type="submit">Log Activity</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>