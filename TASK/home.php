<?php
session_start();
require_once 'db.php';
require_once 'header.php'; // Includes the <head> and starts <body>
require_once 'navbar.php';
?>

<div class="main-content">
    <div class="hero-section">
        <div class="hero-content">
            <h1>Organize Your Life, One Task at a Time.</h1>
            <p class="lead">ProTask helps you manage your daily tasks effortlessly, so you can focus on what truly matters.</p>
            <a href="add_task.php" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Get Started - Add Your First Task!
            </a>
            <a href="index.php" class="btn btn-secondary btn-lg">
                <i class="fas fa-list"></i> View All Tasks
            </a>
        </div>
    </div>

    <div class="features-section">
        <h2>Why Choose ProTask?</h2>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-check-circle feature-icon"></i>
                <h3>Simple & Intuitive</h3>
                <p>Easily add, edit, and manage your tasks with a user-friendly interface.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-calendar-alt feature-icon"></i>
                <h3>Stay Organized</h3>
                <p>Keep track of due dates and prioritize your workload effectively.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-lightbulb feature-icon"></i>
                <h3>Boost Productivity</h3>
                <p>Mark tasks as completed and visualize your progress to stay motivated.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-mobile-alt feature-icon"></i>
                <h3>Responsive Design</h3>
                <p>Access your tasks anytime, anywhere, on any device.</p>
            </div>
        </div>
    </div>

    <div class="call-to-action-bottom">
        <p>Ready to take control of your tasks?</p>
        <a href="add_task.php" class="btn btn-primary btn-lg">
            Start Organizing Now! <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

</body>
</html>