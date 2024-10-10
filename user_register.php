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
    $role = $_POST['role']; // Get role from the form
    $status = $_POST['status']; // Get status from the form
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO tbluser (first_name, last_name, email, username, password, address, city, code, role, status) 
                  VALUES (:fName, :lName, :email, :username, :hashedPassword, :address, :city, :code, :role, :status)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
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

        <!-- Hidden fields for role and status with default values -->
        <input type="hidden" name="role" value="user">
        <input type="hidden" name="status" value="pending">

        <input type="submit" value="Sign Up" name="signUp">
    </form>
</body>
</html>

<!--
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
        <form action="register.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" value="<?php echo isset($surname) ? $surname : ''; ?>"
                required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>"
                required>

            <label for="password">Password:</label>
            <input type="text" id="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>"
                required>


            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo isset($address) ? $address : ''; ?>"
                required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required
                pattern="[0-9]{10}" placeholder="Enter 10 digits">

            <button type="submit" class="register-btn">Register</button>
        </form>

    </section>


</body>

</html>
-->
