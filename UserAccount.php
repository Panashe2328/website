<?php
session_start();

// Database connection using PDO
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$database = "clothingstore";

try {
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Process registration form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
        $role = $_POST['role']; // User role: user or admin
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing

        // SQL query to insert a new user into tblUser
        $query = "INSERT INTO tblUser (role, fName, lName, email, username, password) 
                  VALUES (:role, :fName, :lName, :email, :username, :hashedPassword)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->execute();

        // Registration successful
        $_SESSION['registration_success'] = "Registration successful. Please login.";
        header("Location: login.php");
        exit();
    }

    // Process sign-in form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signIn'])) {
        $login = $_POST['login']; // Email or username
        $password = $_POST['password'];

        // Query to find the user by email or username
        $query = "SELECT * FROM tblUser WHERE email = :login OR username = :login";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid email/username or password.";
            header("Location: login.php");
            exit();
        }
    }
} catch (PDOException $e) {
    // Registration or login failed, handle error
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: register.php");
    exit();
}
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
    <!-- Navigation and Logo -->
</header>

<main>
    <div class="registration-container">
        <!-- Registration Form -->
        <div class="container" id="signup" style="display:none;">
            <h1 class="form-title">Register</h1>
            <form method="post" action="register.php">
                <!-- Username, First Name, Last Name, Email, Password, and Role Selection -->
                <!-- User fields -->
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" id="fName" placeholder="First Name" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user-shield"></i>
                    <select name="role" id="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <input type="submit" class="btn" value="Sign Up" name="signUp">
            </form>
        </div>

        <!-- Sign In Form -->
        <div class="container" id="signIn">
            <h1 class="form-title">Sign In</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="login" id="login" placeholder="Email or Username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <input type="submit" class="btn" value="Sign In" name="signIn">
            </form>
        </div>
    </div>
</main>

<footer>
    <div style="text-align:center;">
        <?php 
        if(isset($_SESSION['email'])){
            $email = $_SESSION['email'];
            $stmt = $db->prepare("SELECT firstName, lastName, username FROM tblUser WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($user){
                echo htmlspecialchars($user['username'] . ' - ' . $user['firstName'] . ' ' . $user['lastName']);  // Escaping output
            }
        }
        ?>
        <a href="logout.php">Logout</a>
    </div>
</footer>

<script src="script.js"></script>
</body>
</html>
