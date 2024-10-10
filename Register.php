<?php
session_start(); // Start the session
include 'dbconn.php'; // Ensure this includes your database connection details

// Registration logic
if (isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $username = $_POST['username']; // Username/email depending on role
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash
    $role = $_POST['role']; // Get the selected role (user/admin)

    try {
        if ($role === 'user') {
            // Insert data into tblUser for regular users
            $stmt = $db->prepare("INSERT INTO tblUser (first_name, last_name, username, password, city, code, status, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $status = 'active'; // Default user status
            $city = $_POST['city']; // Optional fields can be added as required
            $code = $_POST['code'];
            $stmt->execute([$fName, $lName, $username, $password, $city, $code, $status, $role]);
        } else if ($role === 'admin') {
            // Insert data into tblAdmin for admin users
            $adminNum = uniqid('admin'); // Generate a unique admin number
            $stmt = $db->prepare("INSERT INTO tblAdmin (admin_num, first_name, last_name, admin_email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$adminNum, $fName, $lName, $username, $password]); // Use username/email for admin
        }

        echo "Registration successful!";
        header("Location: login.php"); // Redirect to login page
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Login logic
if (isset($_POST['signIn'])) {
    $username = $_POST['username']; // Login using username/email
    $password = $_POST['password'];

    try {
        // Check in tblUser (for users)
        $stmtUser = $db->prepare("SELECT * FROM tblUser WHERE username=?");
        $stmtUser->execute([$username]);
        $userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);

        // Check in tblAdmin (for admins)
        $stmtAdmin = $db->prepare("SELECT * FROM tblAdmin WHERE admin_email=?");
        $stmtAdmin->execute([$username]);
        $adminRow = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if ($userRow) {
            // Verify user password
            if (password_verify($password, $userRow['password'])) {
                $_SESSION['username'] = $userRow['username'];
                $_SESSION['role'] = $userRow['role'];
                header("Location: homepage.php"); // Redirect to user homepage
                exit();
            } else {
                echo "Incorrect Username or Password for User";
            }
        } else if ($adminRow) {
            // Verify admin password
            if (password_verify($password, $adminRow['password'])) {
                $_SESSION['username'] = $adminRow['admin_email'];
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                echo "Incorrect Admin Username or Password";
            }
        } else {
            echo "Incorrect Username or Password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
