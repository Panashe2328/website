<?php
session_start();
include 'dbconn.php'; // Ensure dbconn.php contains your DB connection logic

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['email']; // Can be username or email
    $password = $_POST['password'];

    // Query to find user by username or email
    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login); // Bind both username and email to the same query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];

            // Redirect user to index.php or user dashboard
            header("Location: index.php");
            exit();
        } else {
            $message = "Invalid password. Please try again.";
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
        <div class="logo">
            <img src="_images/pastimes_logo.png" alt="Pastimes Logo" width="150px">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="our_mission.php">Our Mission</a></li>
                <li><a href="browse.php">Browse Clothing</a></li>
                <li><a href="my_account.php">Account</a></li>
                <li><a href="sell_clothes.php">Sell Clothing</a></li>
                <li><a href="contact_us.php">Get in Touch</a></li>
            </ul>
        </nav>
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
        <p>&copy; 2024 Pastimes. All rights reserved.</p>
    </footer>
</body>
</html>

