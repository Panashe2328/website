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

        // Collect user data
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $code = $_POST['code'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert into tblUser
        $query = "INSERT INTO tblUser (first_name, last_name, email, username, password, address, city, code, status) 
                  VALUES (:fName, :lName, :email, :username, :hashedPassword, :address, :city, :code, 'pending')";
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

        // Notify user
        $_SESSION['message'] = "Registration successful. Your account is pending approval.";
        header("Location: register.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: user_signup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
</head>
<body>
    <h1>User Registration</h1>
    <form method="post" action="user_signup.php">
        <input type="text" name="fName" placeholder="First Name" required><br>
        <input type="text" name="lName" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="address" placeholder="Address" required><br>
        <input type="text" name="city" placeholder="City" required><br>
        <input type="text" name="code" placeholder="Postal Code" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
