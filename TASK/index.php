<?php
session_start();
require_once 'db.php';
require_once 'header.php'; // Starts <html><head><body>
require_once 'navbar.php';

// Check user login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['alert_type'] = 'warning';
    $_SESSION['alert_message'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tasks for this user
$sql = "SELECT id, title, description, due_date, status FROM tasks WHERE user_id = ? ORDER BY due_date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Flash success message
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">My Tasks</h1>
        <a href="add_task.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Task
        </a>
    </div>

    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <div class="task-list">
        <?php if ($result->num_rows > 0): ?>
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="task-item">
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo date('M j, Y', strtotime($row['due_date'])); ?></td>
                            <td>
                                <span class="task-status status-<?php echo $row['status']; ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td class="task-actions">
                                <?php if ($row['status'] == 'pending'): ?>
                                    <a href="mark_completed.php?id=<?php echo $row['id']; ?>" title="Mark Complete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="edit_task.php?id=<?php echo $row['id']; ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_task.php?id=<?php echo $row['id']; ?>" 
                                   title="Delete"
                                   onclick="return confirm('Are you sure you want to delete this task?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-tasks empty-icon"></i>
                <h3>No tasks found</h3>
                <p>You don't have any tasks yet. Add your first task to get started!</p>
                <a href="add_task.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Task
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
