<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTask | Task Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php // Inside header.php, right after <body>
$alert_type = $_SESSION['alert_type'] ?? '';
$alert_message = $_SESSION['alert_message'] ?? '';

// Clear session alerts after displaying them once
unset($_SESSION['alert_type']);
unset($_SESSION['alert_message']);

if ($alert_message):
?>
    <div class="main-content"> <div class="alert alert-<?php echo htmlspecialchars($alert_type); ?>">
            <?php echo htmlspecialchars($alert_message); ?>
        </div>
    </div>
<?php endif; ?>