<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location:../Views/login.php');
    exit();
}


$conn = mysqli_connect('localhost', 'root', '', 'shop_db') or die('Connection failed');


$user_id = $_SESSION['user_id'];


if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    
    $delete_sql = "DELETE FROM tasks WHERE task_id = '$task_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $delete_sql)) {
        echo "Task deleted successfully.";
        header("Location: viewTask.php"); 
        exit();
    } else {
        echo "Error deleting task: " . mysqli_error($conn);
    }
} else {
    echo "No task ID provided.";
}

mysqli_close($conn);
?>
