<?php
 session_start(); // Start the session
 include 'dbconn.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Pastimes</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<header>
    <!-- Checkbox to toggle the menu -->
    <input type="checkbox" id="menu-toggle" style="display:none;">
    
    <!-- Burger icon -->
    <label for="menu-toggle" class="burger">
        <div></div>
        <div></div>
        <div></div>
    </label>
    <div class="logo">
        <img src="_images/Pastimes_logo.jpg" alt="Pastimes logo image">
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
   
    <!-- Main Content Section -->
    <main>
        <div class="about-container">
            <h1>About Us</h1>
            <p>
                Pastimes is a platform for buying and selling preloved clothing. We connect buyers
                and sellers, offering a wide range of unique clothing options. Join us for a
                sustainable fashion experience!
            </p>
            <div class="about-images">
            <img src="_images/bracelets.jpg" alt="hand holding bracelets" class="image"  height="150" width="150">
            <img src="_images/shoes.jpg" alt="shoes being hold by a man" class="image" height="150" width="150">
            </div>
            <p>
                At Pastimes, you can easily buy and sell preloved clothing. As a seller, create an account,
                list your items with photos, and set your prices.
            </p>
            <p>
            <div class="about-images">
            <img src="_images/t-shirt.jpg" alt="blue and yellow t-shirts on hangers" class="image" height="150" width="150">
            <img src="_images/glasses.jpg" alt="display of different glasses" class="image" height="150" width="150">
            </div>
                Buyers can browse or search for items they love, add them to their cart, and pay securely
                on our site.
            </p>
            <p>
                Track your orders, manage your listings, and enjoy a seamless experience in sustainable
                fashion!
            </p>
        </div>
    </main>

    <!-- Footer -->
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

        <!-- Footer Branding -->
        <div class="footer-branding">
            <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
