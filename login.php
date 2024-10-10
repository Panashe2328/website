<?php
session_start();
include 'dbconn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Can be username or email
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the role from the form

    if ($role === 'user') {
        // Check if the user is in the tblUser table (user role)
        $stmt = $conn->prepare("SELECT * FROM tbleuser WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $login, $login); // Bind for both username and email
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Check if the password matches the hash
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id']; // Set session ID for user
                echo "User " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";

                // Redirect to user dashboard or profile page
                header("index.php");
                exit();
            } else {
                echo "Invalid password. Please try again.";
            }
        } else {
            echo "User does not exist.";
        }
    } elseif ($role === 'admin') {
        // Check if the user is in the tblAdmin table (admin role)
        $stmt = $conn->prepare("SELECT * FROM tbladmin WHERE admin_email = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Check the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['admin_id']; // Set session ID for admin
                echo "Admin " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";

                // Redirect to admin dashboard
                header("admin_dashboard.php");
                exit();
            } else {
                echo "Invalid admin password. Please try again.";
            }
        } else {
            echo "Admin does not exist.";
        }
    } else {
        echo "Invalid role selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <!-- Sign In Form -->
    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login_handler.php">
            <label for="role">I am a:</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="login" id="login" placeholder="Email or Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required minlength="8">
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
            <p>Don't have an account? <a href="#" onclick="toggleForms();">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
