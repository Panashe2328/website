<?php
session_start();
include("DBConn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <!-- Checkbox to toggle the menu -->
        <input type="checkbox" id="menu-toggle" style="display:none;">
        
        <!-- Label for burger icon (connected to checkbox) -->
        <label for="menu-toggle" class="burger">
            <div></div>
            <div></div>
            <div></div>
        </label>

        <!-- Logo -->
        <div class="logo">
            Pastimes
        </div>

        <!-- Navigation menu -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="User.php">Register</a></li>
            </ul>
        </nav>

        <!-- Header icons -->
        <div class="header-icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-heart"></i>
            <i class="fas fa-shopping-cart"></i>
            <i class="fas fa-user"></i>
        </div>
    </header>
  <main>
    <div class="registration-container">
        <div class="container" id="signup" style="display:none;">
          <h1 class="form-title">Register</h1>
          <form method="post" action="register.php">
            <div class="input-group">
               <i class="fas fa-user"></i>
               <input type="text" name="fName" id="fName" placeholder="First Name" required>
               <label for="fname">First Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
           <input type="submit" class="btn" value="Sign Up" name="signUp">
          </form>
          <p class="or">
            ----------or----------
          </p>
          <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
          </div>
          <div class="links">
            <p>Already Have Account?</p>
            <button id="signInButton">Sign In</button>
          </div>
        </div>

        <div class="container" id="signIn">
            <h1 class="form-title">Sign In</h1>
            <form method="post" action="register.php">
              <div class="input-group">
                  <i class="fas fa-envelope"></i>
                  <input type="email" name="email" id="email" placeholder="Email" required>
                  <label for="email">Email</label>
              </div>
              <div class="input-group">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" id="password" placeholder="Password" required>
                  <label for="password">Password</label>
              </div>
              <p class="recover">
                <a href="#">Recover Password</a>
              </p>
             <input type="submit" class="btn" value="Sign In" name="signIn">
            </form>
            <p class="or">
              ----------or--------
            </p>
            <div class="icons">
              <i class="fab fa-google"></i>
              <i class="fab fa-facebook"></i>
            </div>
            <div class="links">
              <p>Don't have account yet?</p>
              <button id="signUpButton">Sign Up</button>
            </div>
          </div>
    </div>
  
    </main>
    <footer>
        <div class="footer-container">
            <!-- Primary Navigation Links -->
            <div class="footer-navigation">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Home Page</a></li>
                    <li><a href="contact.php">Contact Page</a></li>
                </ul>
            </div>

            <!-- Social Media Integration -->
            <div class="footer-social-media">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
                </ul>
            </div>

            <!-- Newsletter Subscription -->
            <div class="footer-newsletter">
                <h3>Subscribe to Our Newsletter</h3>
                <p>Stay updated with the latest news and exclusive offers!</p>
                <form action="#" method="post">
                    <input type="email" placeholder="Your Email Address" required>
                    <button type="submit">Subscribe Now</button>
                </form>
            </div>

            <!-- Secondary Information -->
            <div class="footer-secondary-info">
                <h3>Additional Links</h3>
                <ul>
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="terms-of-service.php">Terms of Service</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div style="text-align:center; padding:10%;">
            <?php 
                    if(isset($_SESSION['email'])){
                        $email = $_SESSION['email'];
                        $query = mysqli_query($conn, "SELECT users.firstName, users.lastName FROM users WHERE users.email='$email'");
                        while($row = mysqli_fetch_array($query)){
                            echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']);  // Escape user output for security
                        }
                    }
                ?> 
            </p>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Footer Branding -->
        <div class="footer-branding">
            <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
