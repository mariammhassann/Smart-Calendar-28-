<?php
// Start the session to access the logged-in user's info
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
$conn = mysqli_connect('localhost', 'root', '', 'shop_db') or die('Connection failed');

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Check if the task ID is set
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Query to fetch the task details
    $query = "SELECT * FROM tasks WHERE task_id = '$task_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result); // Fetch task data
    } else {
        echo "Task not found.";
        exit();
    }
} else {
    echo "No task ID provided.";
    exit();
}

// Handle the form submission for updating the task
if (isset($_POST['update'])) {
    $task_title = $_POST['task_title'];
    $task_description = $_POST['task_description'];
    $task_date = $_POST['task_date'];
    $task_time = $_POST['task_time'];

    // Update the task in the database
    $update_sql = "UPDATE tasks SET task_title='$task_title', task_description='$task_description', task_date='$task_date', task_time='$task_time' WHERE task_id='$task_id' AND user_id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "Task updated successfully.";
        header("Location: viewTask.php"); // Redirect to tasks list
        exit();
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!-- HTML Form for Editing Task -->
<form method="POST">
<link rel="stylesheet" href="css/editTask.css">
<h2>Edit Task</h2>

    <label for="task_title">Task Title:</label>
    <input type="text" name="task_title" value="<?php echo htmlspecialchars($task['task_title']); ?>" required><br>

    <label for="task_description">Description:</label>
    <textarea name="task_description" required><?php echo htmlspecialchars($task['task_description']); ?></textarea><br>

    <label for="task_date">Date:</label>
    <input type="date" name="task_date" value="<?php echo htmlspecialchars($task['task_date']); ?>" required><br>

    <label for="task_time">Time:</label>
    <input type="time" name="task_time" value="<?php echo htmlspecialchars($task['task_time']); ?>" required><br>

    <button type="submit" name="update">Update Task</button>
</form>
