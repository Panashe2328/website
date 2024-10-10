<?php 
session_start();



include 'DBConn.php'; // establishes the database connection



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Fetch data from the form
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $username = $_POST['username'] ?? ''; // Optional for admin
    $password = $_POST['password'];
    $city = $_POST['city'] ?? ''; // Optional for admin
    $code = $_POST['code'] ?? ''; // Optional for admin
    $role = $_POST['role']; // Comes from the form (dropdown)
    
    // Set status based on the role
    $status = ($role == 'admin') ? 'pending_admin' : 'pending'; // Admin verification status

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Choose the table based on the role
        if ($role == 'user') {
            // Insert into tblUser for regular users
            $query = "INSERT INTO tblUser (first_name, last_name, email, username, password, city, code, status, role) 
                      VALUES (:fName, :lName, :email, :username, :hashedPassword, :city, :code, :status, :role)";
        } else if ($role == 'admin') {
            // Insert into tblAdmin for admin users
            $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password) 
                      VALUES (:fName, :lName, :email, :hashedPassword)";
        }

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);

        if ($role == 'user') {
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':role', $role);
        }

        // Execute the query
        $stmt->execute();

        // Set a session success message and redirect based on role
        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
        if ($role == 'admin') {
            header("Location: http://localhost/website/admin_dashboard.php"); // Redirect to the admin dashboard
        } else {
            header("Location:index.php");
        }
        exit();

    } catch (PDOException $e) {
        // Capture and display error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes - User Registration</title>
    <link rel="stylesheet" href="style.css"> 
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
    <!-- Display any error messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="post" action="user_register.php">
        <div>
            <label for="fName">First Name:</label>
            <input type="text" name="fName" required>
        </div>

        <div>
            <label for="lName">Last Name:</label>
            <input type="text" name="lName" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label for="username">Username (for users):</label>
            <input type="text" name="username">
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label for="city">City (for users):</label>
            <input type="text" name="city">
        </div>

        <div>
            <label for="code">Postal Code (for users):</label>
            <input type="text" name="code">
        </div>

        <div>
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" value="Sign Up" name="signUp">
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

<script src="script.js"></script>
</body>
</html>
