<?php
session_start();
include('dbconn.php'); // Database connection

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
</body>
</html>
