<?php
session_start();
require_once 'db.php';
require_once 'header.php'; // Includes <head> and starts <body>
require_once 'navbar.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['alert_type'] = 'warning';
    $_SESSION['alert_message'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}

// Initialize variables
$error = null;
$title = $description = $due_date = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';

    // Validate
    if (empty($title)) {
        $error = "Title is required";
    } elseif (empty($due_date)) {
        $error = "Due date is required";
    } else {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isss", $user_id, $title, $description, $due_date);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Task added successfully!";
                header("Location: index.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}
?>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">Add New Task</h1>
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
                       value="<?php echo htmlspecialchars($title); ?>" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php 
                    echo htmlspecialchars($description); 
                ?></textarea>
            </div>

            <div class="form-group">
                <label for="due_date" class="form-label">Due Date *</label>
                <input type="date" id="due_date" name="due_date" class="form-control"
                       value="<?php echo htmlspecialchars($due_date); ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Task
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
