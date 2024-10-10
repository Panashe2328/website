<?php
session_start();
include('DBConn.php'); // Database connection

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_email = trim($_POST['admin_email']); // Trim whitespace
    $password = $_POST['password'];

    // Prepare SQL to check admin_email in the tblAdmin table
    $stmt = $conn->prepare("SELECT * FROM tblAdmin WHERE admin_email = ?");
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email exists in the database
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password hash
        if (password_verify($password, $row['password'])) {
            // Admin login success
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['role'] = 'Admin'; // Set role to Admin for session
            header('Location: admin_dashboard.php'); // Redirect to admin dashboard
            exit();
        } else {
            // Password mismatch
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        // Email does not exist
        $error_message = "Admin account does not exist. Please check your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Login</title>
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
            <li><a href="admin_dashboard.php" class= "Current"> Dashboard</a></li>
            <li><a href="user_register.php">Register</a></li>
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
    <h2>Admin Login</h2>
    
    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div> <!-- Escape output for security -->
    <?php endif; ?>
    
    <form method="post" action="AdminLogin.php">
        <label for="admin_email">Admin Email:</label>
        <input type="email" id="admin_email" name="admin_email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="8">
        
        <button type="submit">Login as Admin</button>
    </form>
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
                <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
            </ul>
        </div>

        <div class="footer-newsletter">
            <h3>Subscribe to Our Newsletter</h3>
            <p>Stay updated with the latest news and exclusive offers!</p>
            <form action="#" method="post">
                <input type="email" placeholder="Your Email Address" required>
                <button type="submit">Subscribe Now</button>
            </form>
        </div>

        <div class="footer-secondary-info">
            <h3>Additional Links</h3>
            <ul>
                <li><a href="privacy-policy.php">Privacy Policy</a></li>
                <li><a href="terms-of-service.php">Terms of Service</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>
    </div>

    <div style="text-align:center; padding:15%;">
        <?php 
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $query = mysqli_query($conn, "SELECT firstName, lastName FROM users WHERE email='$email'");
            if ($row = mysqli_fetch_assoc($query)) {
                echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); // Escape user output for security
            }
        }
        ?> 
        <a href="logout.php">Logout</a>
    </div>

    <div class="footer-branding">
        <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
