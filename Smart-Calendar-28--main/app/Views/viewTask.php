<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: ../Views/login.php'); 
    exit();
}


$conn = mysqli_connect('localhost', 'root', '', 'shop_db') or die('Connection failed');


$user_id = $_SESSION['user_id'];


$query = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY task_date DESC";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) > 0) {
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC); 
} else {
    $tasks = [];
}

mysqli_close($conn); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Tasks</title>
    <link rel="stylesheet" href="../../Public/css/viewTasks.css">
</head>
<body>

<div class="task-container">
    <h2>Your Tasks</h2>
    
    <?php if (empty($tasks)): ?>
        <p>No tasks found. <a href="../Controllers/createTask.php">Add a new task</a>.</p>
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
                            
                            <a href="../Controllers/editTask.php?id=<?php echo $task['task_id']; ?>">Edit</a> |
                            <a href="../Controllers/deleteTask.php?id=<?php echo $task['task_id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="../Controllers/createTask.php" class="new-task">Add New Task</a>
    <a href="../Views/home.php" class="back-to-calendar">Done</a>
</div>

</body>
</html>
