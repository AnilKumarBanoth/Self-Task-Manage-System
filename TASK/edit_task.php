<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    $_SESSION['alert_type'] = 'warning';
    $_SESSION['alert_message'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}
// Rest of your page's existing includes and logic follow here

// ...
$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Fetch task details, ensuring it belongs to the current user
$sql = "SELECT id, title, description, due_date, status FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id); // 'ii' for two integers
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Task not found or does not belong to the user
    $_SESSION['alert_type'] = 'danger';
    $_SESSION['alert_message'] = "Task not found or you don't have permission to edit it.";
    header("Location: index.php");
    exit();
}
// ...

require_once 'db.php';
require_once 'header.php'; // Includes the <head> and starts <body>
require_once 'navbar.php';

// Check if task ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$task_id = intval($_GET['id']);

// Fetch task details
$sql = "SELECT id, title, description, due_date, status FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$task = $result->fetch_assoc();
$stmt->close(); // Close the statement

$error = null; // Initialize error variable for edit page

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Validate
    if (empty($title)) {
        $error = "Title is required";
    } elseif (empty($due_date)) {
        $error = "Due date is required";
    } else {
        // Update with prepared statement
        $sql = "UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssssi", $title, $description, $due_date, $status, $task_id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Task updated successfully!";
                header("Location: index.php");
                exit();
            } else {
                $error = "Error updating task: " . $stmt->error;
            }
            $stmt->close(); // Close the statement
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}
?>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">Edit Task</h1>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="task-form">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title" class="form-label">Title *</label>
                <input type="text" id="title" name="title" class="form-control" 
                       value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php 
                    echo htmlspecialchars($task['description']); 
                ?></textarea>
            </div>

            <div class="form-group">
                <label for="due_date" class="form-label">Due Date *</label>
                <input type="date" id="due_date" name="due_date" class="form-control" 
                       value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Task
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>