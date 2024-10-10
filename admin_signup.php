<?php
session_start();
require_once 'dbconn.php'; // establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO tbladmin (first_name, last_name, admin_email, password) 
                  VALUES (:fName, :lName, :email, :hashedPassword)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->execute();

        $_SESSION['registration_success'] = "Admin registration successful. Please login.";
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
    <title>Admin Registration</title>
</head>
<body>
    <h1>Admin Registration</h1>
    <form method="post" action="admin_signup.php">
        <label>First Name:</label>
        <input type="text" name="fName" required><br>

        <label>Last Name:</label>
        <input type="text" name="lName" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Sign Up" name="signUp">
    </form>
</body>
</html>
