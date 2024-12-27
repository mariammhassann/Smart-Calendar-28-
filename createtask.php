<?php 
include 'config.php'; // Include your database connection settings

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to create a task.");
}

$host = 'localhost';
$username = 'root';
$password = ''; 
$database = 'shop_db';
$conn = mysqli_connect($host, $username, $password, $database) or die('Connection failed: ' . mysqli_connect_error());

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $taskTitle = $conn->real_escape_string($_POST['task_title']);
    $taskDate = $conn->real_escape_string($_POST['task_date']);
    $taskTime = $conn->real_escape_string($_POST['task_time']);
    $taskDescription = $conn->real_escape_string($_POST['task_description']);
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    // Insert the data into the tasks table
    $sql = "INSERT INTO tasks (task_title, task_date, task_time, task_description, user_id) 
            VALUES ('$taskTitle', '$taskDate', '$taskTime', '$taskDescription', '$userId')";

    if ($conn->query($sql) === TRUE) {
        echo "Task saved";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="css/task.css">
</head>
<body>
    <!-- Task Container -->
    <div class="task-container">
        <h2>Create New Task</h2>
        <form method="POST" action="createTask.php">
            <input type="text" name="task_title" placeholder="Task Title" required>
            <input type="date" name="task_date" required>
            <input type="time" name="task_time" required>
            <textarea name="task_description" placeholder="Task Description" rows="3"></textarea>
            <button class="add-task" type="submit">Add Task</button>
            <a href="home.php" class="add-task">Done</a>


        </form>
    </div>
    
    <!-- Success Message -->
    <p class="success-message">Task added successfully!</p>
</body>
</html>
