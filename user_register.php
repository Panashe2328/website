<?php 
session_start();
include 'DBConn.php'; // Establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Fetch data from the form
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $username = $_POST['username'] ?? ''; // Optional for admin
    $password = $_POST['password'];
    $city = $_POST['city'] ?? ''; // Optional for admin
    $code = $_POST['code'] ?? ''; // Optional for admin
    $address = $_POST['address'] ?? ''; // Optional for users
    $role = $_POST['role']; // Comes from the form (dropdown)

    // Set status based on the role
    $status = ($role == 'admin') ? 'pending_admin' : 'pending'; // Admin verification status

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Choose the table based on the role
        if ($role == 'user') {
            // Insert into tblUser for regular users
            $query = "INSERT INTO tblUser (first_name, last_name, username, password, address, city, code, status, role) 
                      VALUES (:fName, :lName, :username, :hashedPassword, :address, :city, :code, :status, :role)";
        } else if ($role == 'admin') {
            // Insert into tblAdmin for admin users
            $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password) 
                      VALUES (:fName, :lName, :email, :hashedPassword)";
        }

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':hashedPassword', $hashedPassword);

        if ($role == 'user') {
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':role', $role);
        } else if ($role == 'admin') {
            $email = $_POST['email']; // Fetch email only for admin
            $stmt->bindParam(':email', $email);
        }

        // Execute the query
        $stmt->execute();

        // Set session variable for success message
        $_SESSION['registration_success'] = true;
        header("Location: user_register.php"); // Reload the page to show the message
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
    <title>Pastimes - User Registration</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        // JavaScript to display the pop-up message
        window.onload = function() {
            <?php if (isset($_SESSION['registration_success'])): ?>
                alert("Registration received. Please wait for admin approval.");
                <?php unset($_SESSION['registration_success']); // Unset after showing ?>
            <?php endif; ?>
        };
    </script>
</head>
<body>
<!-- Your form and other content here -->
</body>
</html>
