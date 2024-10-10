<?php 
session_start();
require_once 'dbconn.php'; // establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Fetch data from the form
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $code = $_POST['code'];
    $role = $_POST['role']; // Comes from the form (dropdown)
    $status = ($role == 'admin') ? 'pending_admin' : 'pending'; // Admin verification status

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Choose the table based on the role
        if ($role == 'user') {
            // Insert into tblUser for regular users
            $query = "INSERT INTO tblUser (first_name, last_name, email, username, password, city, code, role, status) 
                      VALUES (:fName, :lName, :email, :username, :hashedPassword, :city, :code, :role, :status)";
        } else if ($role == 'admin') {
            // Insert into tblAdmin for admin users
            $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password, role, status) 
                      VALUES (:fName, :lName, :email, :hashedPassword, :role, :status)";
        }

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':fName', $fName);
        $stmt->bindParam(':lName', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        if ($role == 'user') {
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':code', $code);
        }
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);

        // Execute the query
        $stmt->execute();

        // Set a session success message and redirect to the login page
        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
        header("Location: login.php ");
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

   <main>
       <!-- Display any error messages -->
       <?php if (isset($_SESSION['error'])): ?>
           <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
       <?php endif; ?>
       
       <form method="post" action="user_signup.php">
           <div>
               <label for="fName">First Name:</label>
               <input type="text" name="fName" required><br>
           </div>

           <div>
               <label for="lName">Last Name:</label>
               <input type="text" name="lName" required><br>
           </div>

           <div>
               <label for="email">Email:</label>
               <input type="email" name="email" required><br>
           </div>

           <div>
               <label for="username">Username (for users):</label>
               <input type="text" name="username"><br>
           </div>

           <div>
               <label for="password">Password:</label>
               <input type="password" name="password" required><br>
           </div>

           <div>
               <label for="city">City (for users):</label>
               <input type="text" name="city"><br>
           </div>

           <div>
               <label for="code">Postal Code (for users):</label>
               <input type="text" name="code"><br>
           </div>

           <div>
               <label for="role">Role:</label>
               <select name="role" required>
                   <option value="user">User</option>
                   <option value="admin">Admin</option>
               </select><br>
           </div>

           <input type="submit" value="Sign Up" name="signUp">
       </form>
   </main>
</body>
</html>
