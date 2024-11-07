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
    
    // Only for admin role
    $adminNumber = ($role == 'admin') ? $_POST['admin_num'] : null;

    $status = ($role == 'admin') ? 'pending_admin' : 'pending'; // Admin verification status

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Choose the table based on the role
        if ($role == 'user') {
            $query = "INSERT INTO tblUser (first_name, last_name, username, password, address, city, code, status, role) 
                      VALUES (:fName, :lName, :username, :hashedPassword, :address, :city, :code, :status, :role)";
        } else if ($role == 'admin') {
            $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password, admin_num) 
                      VALUES (:fName, :lName, :email, :hashedPassword, :admin_num)";
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
            $stmt->bindParam(':admin_num', $adminNumber);
        }

        // Execute the query
        $stmt->execute();

        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
        if ($role == 'admin') {
            $_SESSION['admin_id'] = $email;
            $_SESSION['role'] = 'Admin';
            header("Location: http://localhost//admin_dashboard.php");
        } else {
            echo "<script>alert('Successful registration, waiting for approval.');</script>";
            header("Location: index.php");
        }
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
    <title>Pastimes - User Registration</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<main>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="post" action="user_register.php">
        <div>
            <label for="fName">First Name:</label>
            <input type="text" name="fName" required>
        </div>

        <div>
            <label for="lName">Last Name:</label>
            <input type="text" name="lName" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email">
        </div>

        <div id="username-field">
            <label for="username">Username (for users):</label>
            <input type="text" name="username">
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>

        <div id="admin-number-field">
            <label for="adminNumber">Admin Number:</label>
            <input type="text" name="admin_num" pattern="\d{5}" title="Please enter a 5-digit number">
        </div>

        <div id="address-field">
            <label for="address">Address (for users):</label>
            <input type="text" name="address">
        </div>

        <div id="city-field">
            <label for="city">City (for users):</label>
            <input type="text" name="city">
        </div>

        <div id="code-field">
            <label for="code">Postal Code (for users):</label>
            <input type="text" name="code">
        </div>

        <div>
            <label for="role">Role:</label>
            <select name="role" required onchange="toggleFields(this.value)">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" value="Sign Up" name="signUp">
    </form>
</main>

<script>
    function toggleFields(role) {
        document.getElementById('username-field').style.display = role === 'user' ? 'block' : 'none';
        document.getElementById('address-field').style.display = role === 'user' ? 'block' : 'none';
        document.getElementById('city-field').style.display = role === 'user' ? 'block' : 'none';
        document.getElementById('code-field').style.display = role === 'user' ? 'block' : 'none';
        document.getElementById('admin-number-field').style.display = role === 'admin' ? 'block' : 'none';
    }
</script>
</body>
</html>
