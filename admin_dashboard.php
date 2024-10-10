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
    <title>Admin Dashboard - Pastimes</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<header>
    <input type="checkbox" id="menu-toggle" style="display:none;"> <!-- Checkbox to toggle the menu -->
    
    <label for="menu-toggle" class="burger">
        <div></div>
        <div></div>
        <div></div>
    </label>

    <div class="logo">
        <img src="_images/Pastimes_logo.jpg" alt="Pastimes logo">
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="Register.php">Register</a></li>
            <li><a href="logout.php">Logout</a></li> <!-- Implement logout.php to destroy session -->
        </ul>
    </nav>

    <div class="header-icons">
        <i class="fas fa-search"></i>
        <i class="fas fa-heart"></i>
        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
        <i class="fas fa-user"></i>
    </div>
</header>

<main>
    <h1>Welcome, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?>!</h1>
    <!-- Add admin dashboard content here -->
</main>

<footer>
    <div class="footer-container">
        <div class="footer-navigation">
            <h3>Navigation</h3>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="contact.php">Contact Page</a></li>
            </ul>
        </div>

        <div class="footer-social-media">
            <h3>Follow Us</h3>
            <ul>
                <li><a href
