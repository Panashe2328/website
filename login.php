<?php
session_start();
include 'DBConn.php'; //include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['email']; //can be username or email
    $password = $_POST['password'];

    //check if the input looks like an email (basic email validation using regex)
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        //its an email, so check the Admin table
        $stmt = $db->prepare("SELECT * FROM tblAdmin WHERE admin_email = ?");
    } else {
        //its an username, so check the User table
        $stmt = $db->prepare("SELECT * FROM tblUser WHERE username = ?");
    }

    //execute the query with the login (email or username)
    $stmt->execute([$login]);

    //fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //check if the user exists
    if ($result) {
        //check if the account is approved
        if ($result['status'] === 'pending') {
            $message = "Your account is pending approval. Please wait for an admin to approve your registration.";
        } else {
            //verify the password
            if (password_verify($password, $result['password'])) {
                //check role and set appropriate session variables and redirect
                if (isset($result['admin_email'])) {  // This indicates it's an Admin
                    $_SESSION['admin_id'] = $result['admin_id']; 
                    $_SESSION['role'] = 'Admin';
                    header("Location: admin_dashboard.php");
                } else {
                    //regular user login
                    $_SESSION['user_id'] = $result['user_id']; 
                    $_SESSION['first_name'] = $result['first_name'];
                    $_SESSION['role'] = 'User';
                    $_SESSION['show_popup'] = true;  //show the pop-up
                    header("Location: add_clothing.php");
                }
                exit();
            } else {
                $message = "Invalid password. Please try again.";
            }
        }
    } else {
        $message = "User does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pastimes - Login</title>
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

<section class="login-form">
    <h2>Log into your account</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="email">Email or Username:</label>
        <input type="text" id="email" name="email" value="<?php echo isset($login) ? htmlspecialchars($login) : ''; ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="login-btn">Login</button>
    </form>

    <p>Don't have an account? <a href="user_registration.php">Sign up here</a>.</p>
</section>

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
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $stmt = $db->prepare("SELECT first_name, last_name FROM tblUser WHERE user_id = ?");
            $stmt->execute([$user_id]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); // Escape output for security
            }
        }
        ?> 
        <a href="logout.php">Logout</a>
    </div>

    <div class="footer-branding">
        <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
    </div>
</footer>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.querySelector('nav');

    menuToggle.addEventListener('change', () => {
        nav.style.display = menuToggle.checked ? 'flex' : 'none';
    });
</script>
</body>
</html>
