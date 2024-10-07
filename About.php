<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Pastimes</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM16mK1l23n+W1v9Q/RFZ/WVd4F5eDjqzXU9Yw" crossorigin="anonymous">
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
                <li><a href="Contact.php">Contact</a></li>
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
                <img src="path_to_image_1.jpg" alt="Image 1">
                <img src="path_to_image_2.jpg" alt="Image 2">
                <img src="path_to_image_3.jpg" alt="Image 3">
                <img src="path_to_image_4.jpg" alt="Image 4">
            </div>
            <p>
                At Pastimes, you can easily buy and sell preloved clothing. As a seller, create an account,
                list your items with photos, and set your prices.
            </p>
            <p>
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
