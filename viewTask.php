<?php
// Start the session to access the logged-in user's info
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include the database connection
$conn = mysqli_connect('localhost', 'root', '', 'shop_db') or die('Connection failed');

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query to fetch tasks for the logged-in user
$query = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY task_date DESC";
$result = mysqli_query($conn, $query);

// Check if there are any tasks
if (mysqli_num_rows($result) > 0) {
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC); // Fetch all tasks as an associative array
} else {
    $tasks = [];
}

mysqli_close($conn); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Tasks</title>
    <link rel="stylesheet" href="css/viewTasks.css">
</head>
<body>

<div class="task-container">
    <h2>Your Tasks</h2>
    
    <?php if (empty($tasks)): ?>
        <p>No tasks found. <a href="createTask.php">Add a new task</a>.</p>
    <?php else: ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Task Title</th>
                    <th>Task Date</th>
                    <th>Task Time</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['task_title']); ?></td>
                        <td><?php echo htmlspecialchars($task['task_date']); ?></td>
                        <td><?php echo htmlspecialchars($task['task_time']); ?></td>
                        <td><?php echo htmlspecialchars($task['task_description']); ?></td>
                        <td>
                            
                            <a href="editTask.php?id=<?php echo $task['task_id']; ?>">Edit</a> |
                            <a href="deleteTask.php?id=<?php echo $task['task_id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="createTask.php" class="new-task">Add New Task</a>
    <a href="calender.php" class="back-to-calendar">Back to Calendar</a>
</div>

</body>
</html>
