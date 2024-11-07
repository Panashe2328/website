<?php
session_start();
include 'DBConn.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['username']; // Username input for users
    $password = $_POST['password'];

    // Check the User table
    $stmt = $db->prepare("SELECT * FROM tblUser WHERE username = ?");
    $stmt->execute([$login]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists
    if ($result) {
        // Verify the password
        if (password_verify($password, $result['password'])) {
            // Set session variables for user
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['first_name'] = $result['first_name'];
            $_SESSION['role'] = 'User';
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
    <title>User Login</title>
</head>

<body>
<section class="login-form">
    <h2>User Login</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="loginUser.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="login-btn">Login</button>
    </form>
    <p>Don't have an account? <a href="user_registration.php">Sign up here</a>.</p>
</section>
</body>
</html>
