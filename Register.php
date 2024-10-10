<?php
session_start();
<<<<<<< HEAD

// Database connection using PDO
$hostname = "localhost";
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
        $address = $_POST['address'];
        $city = $_POST['city'];
        $code = $_POST['code'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing

        // SQL query to insert a new user into tblUser or tblAdmin based on the role
        if ($role === 'user') {
            $query = "INSERT INTO tbluser (role, first_name, last_name, email, username, password, address, city, code, status) 
                      VALUES (:role, :fName, :lName, :email, :username, :hashedPassword, :address, :city, :code, 'pending')";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':code', $code);
        } else {
            $query = "INSERT INTO tbladmin (first_name, last_name, admin_email, password) 
                      VALUES (:fName, :lName, :email, :hashedPassword)";
            $stmt = $db->prepare($query);
        }

        // Bind common parameters
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
        $query = "SELECT * FROM tbluser WHERE email = :login OR username = :login";
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
                header("Location: admin_dashboard.php");
            } else {
                header("Location:index.php");
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
=======
>>>>>>> 4b4fbe53b44898b2479212c3e5153f4825700041
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        button {
            margin: 10px;
            padding: 10px 20px;
            background-color: lightcoral;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: lightcyan;
        }
    </style>
</head>
<body>
<<<<<<< HEAD
<header>
    <!-- Navigation and Logo -->
</header>

<main>
    <div class="registration-container">
        <!-- Registration Form -->
        <div class="container" id="signup" style="display:none;">
            <h1 class="form-title">Register</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Username (for login)" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" id="fName" placeholder="First Name (your given name)" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" id="lName" placeholder="Last Name (your family name)" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email (your email address)" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password (your secure password)" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user-shield"></i>
                    <select name="role" id="role" required onchange="showAdditionalFields()">
                        <option value="" disabled selected>Select Role (user/admin)</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div id="additionalFields" style="display:none;">
                    <div class="input-group">
                        <i class="fas fa-home"></i>
                        <input type="text" name="address" id="address" placeholder="Address (your residence)" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-city"></i>
                        <input type="text" name="city" id="city" placeholder="City (your city of residence)" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-code"></i>
                        <input type="text" name="code" id="code" placeholder="Postal Code (your postal code)" required>
                    </div>
                </div>
                <input type="submit" class="btn" value="Sign Up" name="signUp">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </form>
        </div>

       <!-- Sign In Form -->
<div class="container" id="signIn">
    <h1 class="form-title">Sign In</h1>
    <form method="post" action="login.php"> 
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="login" id="login" placeholder="Email or Username (for login)" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password (your secure password)" required>
        </div>
        <input type="submit" class="btn" value="Sign In" name="signIn">
        <p>Don't have an account? <a href="#" onclick="toggleForms();">Sign Up</a></p>
    </form>
</div>

=======
    <div class="container">
        <h1>Choose Registration Type</h1>
        <button onclick="window.location.href='user_signup.php'">Register as User</button>
        <button onclick="window.location.href='admin_signup.php'">Register as Admin</button>
>>>>>>> 4b4fbe53b44898b2479212c3e5153f4825700041
    </div>
</body>
</html>
