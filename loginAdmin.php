<?php
session_start();
include 'DBConn.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['email']; // Email input for admins
    $password = $_POST['password'];

    // Check the Admin table
    $stmt = $db->prepare("SELECT * FROM tblAdmin WHERE email = ?");
    $stmt->execute([$login]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the admin exists
    if ($result) {
        // Verify the password
        if (password_verify($password, $result['password'])) {
            // Set session variables for admin
            $_SESSION['admin_id'] = $result['admin_id'];
            $_SESSION['role'] = 'Admin';
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Invalid password. Please try again.";
        }
    } else {
        $message = "Admin does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Login</title>
</head>

<body>
<section class="login-form">
    <h2>Admin Login</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="loginAdmin.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="login-btn">Login</button>
    </form>
</section>
</body>
</html>
