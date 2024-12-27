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

    // Query to delete the task from the database
    $delete_sql = "DELETE FROM tasks WHERE task_id = '$task_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $delete_sql)) {
        echo "Task deleted successfully.";
        header("Location: viewTask.php"); // Redirect to tasks list
        exit();
    } else {
        echo "Error deleting task: " . mysqli_error($conn);
    }
} else {
    echo "No task ID provided.";
}

mysqli_close($conn);
?>
