<?php
session_start(); // Start the session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Additional functionality for admin dashboard can be added here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <!-- Add more navigation links as needed -->
                <li><a href="logout.php">Logout</a></li> <!-- Implement logout.php to destroy session -->
            </ul>
        </nav>
    </header>
    <main>
        <h1>Welcome, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?>!</h1>
        <!-- Add admin dashboard content here -->
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
