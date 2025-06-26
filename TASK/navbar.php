<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
            <i class="fas fa-tasks"></i>
            <span>ProTask</span>
        </div>
        
   

        <div class="navbar-links">
            <a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'home.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Tasks
            </a>
            <?php if (isset($_SESSION['user_id'])): // Show Add Task only if logged in ?>
                <a href="add_task.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'add_task.php' ? 'active' : ''; ?>">
                    <i class="fas fa-plus-circle"></i> Add Task
                </a>
                <a href="logout.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'logout.php' ? 'active' : ''; ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                </a>
            <?php else: // Show Login/Register if logged out ?>
                <a href="login.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'login.php' ? 'active' : ''; ?>">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="register.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : ''; ?>">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>