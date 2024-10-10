<?php 
session_start();
include 'DBConn.php'; // establishes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Fetch data from the form
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $username = $_POST['username'] ?? ''; // Optional for admin
    $password = $_POST['password'];
    $city = $_POST['city'] ?? ''; // Optional for admin
    $code = $_POST['code'] ?? ''; // Optional for admin
    $role = $_POST['role']; // Comes from the form (dropdown)
    
    // For regular users, status is managed. For admins, it's not needed.
    $status = ($role == 'user') ? 'pending' : ''; 

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Choose the table based on the role
        if ($role == 'user') {
            // Insert into tblUser for regular users
            $query = "INSERT INTO tblUser (first_name, last_name, email, username, password, city, code, status, role) 
                      VALUES (:fName, :lName, :email, :username, :hashedPassword, :city, :code, :status, :role)";
        } else if ($role == 'admin') {
            // Insert into tblAdmin for admin users (no role or status fields)
            $query = "INSERT INTO tblAdmin (first_name, last_name, admin_email, password) 
                      VALUES (:fName, :lName, :email, :hashedPassword)";
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
            $stmt->bindParam(':status', $status); // Only for users
            $stmt->bindParam(':role', $role);     // Only for users
        }

        // Execute the query
        $stmt->execute();

        // Set a session success message and redirect based on role
        $_SESSION['registration_success'] = "Registration successful. Please wait until approval.";
        if ($role == 'admin') {
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
        } else {
            header("Location: index.php");
        }
        exit();

    } catch (PDOException $e) {
        // Capture and display error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
?>
