<?php
session_start();
?>
<header>
    <div class="logo">FitFlow</div>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="log_activity.php">Log Activity</a></li>
                <li><a href="view_activities.php">My Activities</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>