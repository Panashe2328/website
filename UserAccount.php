<?php
session_start(); // Start the session
include 'dbconn.php';
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
    <input type="checkbox" id="menu-toggle" style="display:none;">
    <label for="menu-toggle" class="burger">
        <div></div>
        <div></div>
        <div></div>
    </label>
    <div class="logo">
        <img src="_images/Pastimes_logo.jpg" alt="Pastimes logo image">
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="User.php">Register</a></li>
        </ul>
    </nav>
    <div class="header-icons">
        <i class="fas fa-search"></i>
        <i class="fas fa-heart"></i>
        <i class="fas fa-shopping-cart"></i>
        <i class="fas fa-user"></i>
    </div>
</header>
<main>
    <div class="registration-container">
        <div class="container" id="signup">
            <h1 class="form-title">Register</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <select name="role" id="role" required onchange="toggleFields()">
                        <option value="" disabled selected>Select Role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <label for="role">Role</label>
                </div>

                <!-- User specific fields -->
                <div class="user-fields" style="display:none;">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="Username" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="fName" id="fName" placeholder="First Name" required>
                        <label for="fName">First Name</label>
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
                </div>

                <!-- Admin specific fields -->
                <div class="admin-fields" style="display:none;">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="fName" id="fNameAdmin" placeholder="First Name" required>
                        <label for="fNameAdmin">First Name</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="lName" id="lNameAdmin" placeholder="Last Name" required>
                        <label for="lNameAdmin">Last Name</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="emailAdmin" placeholder="Email" required>
                        <label for="emailAdmin">Email</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="passwordAdmin" placeholder="Password" required>
                        <label for="passwordAdmin">Password</label>
                    </div>
                </div>

                <input type="submit" class="btn" value="Sign Up" name="signUp">
            </form>
            <p class="or">----------or----------</p>
            <div class="icons">
                <i class="fab fa-google"></i>
                <i class="fab fa-facebook"></i>
            </div>
            <div class="links">
                <p>Already Have an Account?</p>
                <button id="signInButton">Sign In</button>
            </div>
        </div>

        <div class="container" id="signIn">
            <h1 class="form-title">Sign In</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="login" id="login" placeholder="Email or Username" required>
                    <label for="login">Email or Username</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <p class="recover"><a href="#">Recover Password</a></p>
                <input type="submit" class="btn" value="Sign In" name="signIn">
            </form>
            <p class="or">----------or----------</p>
            <div class="icons">
                <i class="fab fa-google"></i>
                <i class="fab fa-facebook"></i>
            </div>
            <div class="links">
                <p>Don't have an account yet?</p>
                <button id="signUpButton">Sign Up</button>
            </div>
        </div>
    </div>
</main>

<script>
function toggleFields() {
    var role = document.getElementById('role').value;
    var userFields = document.querySelector('.user-fields');
    var adminFields = document.querySelector('.admin-fields');

    if (role === 'user') {
        userFields.style.display = 'block';
        adminFields.style.display = 'none';
    } else if (role === 'admin') {
        adminFields.style.display = 'block';
        userFields.style.display = 'none';
    } else {
        userFields.style.display = 'none';
        adminFields.style.display = 'none';
    }
}
</script>

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

    <div style="text-align:center; padding:10%;">
        <?php 
        if(isset($_SESSION['email'])){
            $email = $_SESSION['email'];
            $query = mysqli_query($conn, "SELECT firstName, lastName, username FROM tblUser WHERE email='$email'");
            while($row = mysqli_fetch_array($query)){
                echo htmlspecialchars($row['username'] . ' - ' . $row['firstName'] . ' ' . $row['lastName']);
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
