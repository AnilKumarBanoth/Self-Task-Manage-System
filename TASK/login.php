<?php
session_start();
require_once 'db.php';
require_once 'header.php';
require_once 'navbar.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Both username and password are required.";
    } else {
        // Fetch user from database
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['alert_type'] = 'success';
                $_SESSION['alert_message'] = "Welcome, " . htmlspecialchars($user['username']) . "!";
                header("Location: index.php"); // Redirect to the tasks page
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    }
}

// Display any success messages from previous redirects (e.g., from register.php)
$alert_type = $_SESSION['alert_type'] ?? '';
$alert_message = $_SESSION['alert_message'] ?? '';
unset($_SESSION['alert_type']);
unset($_SESSION['alert_message']);
?>

<div class="main-content">
    <div class="task-form">
        <h1 class="page-title">Login</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <?php if ($alert_message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($alert_type); ?>">
                <?php echo htmlspecialchars($alert_message); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username" class="form-label">Username *</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password *</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
        </form>
    </div>
</div>

</body>
</html>