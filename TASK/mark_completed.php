<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    $_SESSION['alert_type'] = 'warning';
    $_SESSION['alert_message'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}
// For delete_task.php and mark_completed.php
$user_id = $_SESSION['user_id']; // Get logged-in user's ID
$id = intval($_GET['id']); // Sanitize task ID

// Example for delete_task.php
$sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ii", $id, $user_id);
    // ... rest of the delete logic
}

// Example for mark_completed.php
$sql = "UPDATE tasks SET status = 'completed' WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ii", $id, $user_id);
    // ... rest of the mark completed logic
}
require_once 'header.php';
require_once 'navbar.php';

require_once 'db.php'; // Ensure db.php is included

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID to integer

    // Use prepared statement for UPDATE to prevent SQL injection
    $sql = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Task marked as completed!";
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating task: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database error: " . $conn->error;
    }
} else {
    echo "No task ID provided.";
}
$conn->close(); // Close database connection
?>