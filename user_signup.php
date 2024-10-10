<?php
session_start();
require_once 'dbconn.php'; // establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $code = $_POST['code'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO tbluser (role, first_name, last_name, email, username, password, address, city, code, status) 
                  VALUES ('user', :fName, :lName, :email, :username, :hashedPassword, :address, :city, :code, 'pending')";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $_SESSION['registration_success'] = "Registration successful. Please login.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h1>User Registration</h1>
    <form method="post" action="user_signup.php">
        <label>First Name:</label>
        <input type="text" name="fName" required><br>

        <label>Last Name:</label>
        <input type="text" name="lName" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Address:</label>
        <input type="text" name="address" required><br>

        <label>City:</label>
        <input type="text" name="city" required><br>

        <label>Postal Code:</label>
        <input type="text" name="code" required><br>

        <input type="submit" value="Sign Up" name="signUp">
    </form>
</body>
</html>
