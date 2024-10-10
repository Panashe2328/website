<?php
session_start();
require_once 'dbconn.php'; // establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Fetch data from form
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $code = $_POST['code'];
    $role = $_POST['role']; // Hidden field
    $status = $_POST['status']; // Hidden field

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Insert the user data into the tblUser table
        $query = "INSERT INTO tblUser (first_name, last_name, email, username, password, city, code, role, status) 
                  VALUES (:fName, :lName, :email, :username, :hashedPassword, :city, :code, :role, :status)";
        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);

        // Execute the query
        $stmt->execute();

        // Set a session success message and redirect to login page
        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Capture and display error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pastimes - User Registration</title>
</head>
<body>
    <header>
        <!-- nav bar -->
        <div class="logo">
            <img src="_images/pastimes_logo.png" alt="" width="150px">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="browse.php">Browse Clothing</a></li>
                <li><a href="my_account.php">Account</a></li>
                <li><a href="sell_clothes.php">Sell Clothing</a></li>
                <li><a href="contact_us.php">Get in Touch</a></li>
            </ul>
        </nav>
    </header>

    <section class="registration-form">
        <h1>User Registration</h1>
        <form method="post" action="user_signup.php">
            <label for="fName">First Name:</label>
            <input type="text" name="fName" required><br>

            <label for="lName">Last Name:</label>
            <input type="text" name="lName" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="city">City:</label>
            <input type="text" name="city" required><br>

            <label for="code">Postal Code:</label>
            <input type="text" name="code" required><br>

            <!-- Hidden fields for role and status with default values -->
            <input type="hidden" name="role" value="user">
            <input type="hidden" name="status" value="pending">

            <input type="submit" value="Sign Up" name="signUp">
        </form>
    </section>
</body>
</html>
