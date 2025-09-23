<?php
include 'includes/functions.php';
checkLoggedIn();
include 'includes/db_connect.php';

$userId = $_SESSION['user_id'];
$sql = "SELECT a.date, a.duration_minutes, at.name as activity_type, 
               a.distance_km, a.sets, a.reps, a.weight_kg, a.notes
        FROM activities a
        JOIN activity_types at ON a.activity_type_id = at.id
        WHERE a.user_id = ?
        ORDER BY a.date DESC, a.id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Activities - FitFlow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2>My Activities</h2>
        <?php if (empty($activities)): ?>
            <p>You have not logged any activities yet.</p>
        <?php else: ?>
            <table class="activities-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Activity</th>
                        <th>Duration (min)</th>
                        <th>Details</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $activity): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($activity['date']); ?></td>
                            <td><?php echo htmlspecialchars($activity['activity_type']); ?></td>
                            <td><?php echo htmlspecialchars($activity['duration_minutes']); ?></td>
                            <td>
                                <?php
                                $details = [];
                                if ($activity['distance_km']) $details[] = $activity['distance_km'] . ' km';
                                if ($activity['sets']) $details[] = $activity['sets'] . ' sets';
                                if ($activity['reps']) $details[] = $activity['reps'] . ' reps';
                                if ($activity['weight_kg']) $details[] = $activity['weight_kg'] . ' kg';
                                echo implode(', ', $details);
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($activity['notes']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>