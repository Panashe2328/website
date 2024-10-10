<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "clothingstore";
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Collect admin data
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert into tblAdmin
        $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password) 
                  VALUES (:fName, :lName, :email, :hashedPassword)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);

        $stmt->execute();

        // Notify user
        $_SESSION['message'] = "Registration successful. Your account is pending approval.";
        header("Location: register.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: admin_signup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up</title>
</head>
<body>
    <h1>Admin Registration</h1>
    <form method="post" action="admin_signup.php">
        <input type="text" name="fName" placeholder="First Name" required><br>
        <input type="text" name="lName" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Admin Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
