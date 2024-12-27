<?php
session_start();

// Database Connection
$conn = mysqli_connect('localhost', 'root', '', 'shop_db') or die('connection failed');

$user_id = $_SESSION['user_id']; // Assume user_id is stored in session

// Fetch Notifications for the Logged-in User
$query = "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY notification_date DESC";
$result = mysqli_query($conn, $query);

// Store notifications in an array
$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="css/notifications.css">
</head>
<body>
    <div class="container">
        <h1>Notifications</h1>

        <!-- Notification List -->
        <div class="notification-list">
            <?php if (empty($notifications)) : ?>
                <p class="no-notifications">No notifications available.</p>
            <?php else : ?>
                <?php foreach ($notifications as $notification) : ?>
                    <div class="notification-item">
                        <p class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></p>
                        <span class="notification-date"><?php echo htmlspecialchars($notification['notification_date']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <a href="home.php" class="back-button">Done</a>
    </div>
</body>
</html>
