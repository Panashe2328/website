<?php
session_start(); // Start the session
include 'dbconn.php'; // Include your database connection file

// Sign Up Logic
if (isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $username = $_POST['username']; // Capture the username
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
    $status = 'active'; // Default status
    $role = $_POST['role']; // Get the selected role

    try {
        if ($role === 'user') {
            // Insert data into tblUser
            $stmt = $db->prepare("INSERT INTO tblUser (first_name, last_name, username, password, status, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$fName, $lName, $username, $password, $status, $role]);
        } else if ($role === 'admin') {
            // Insert data into tblAdmin
            $adminNum = uniqid('admin'); // Generate unique admin number
            $stmt = $db->prepare("INSERT INTO tblAdmin (admin_num, first_name, last_name, admin_email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$adminNum, $fName, $lName, $email, $password]); // Using email for admin
        }

        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Sign In Logic
if (isset($_POST['signIn'])) {
    $input = $_POST['email']; // Input field can accept either email (for admin) or username (for user)
    $password = $_POST['password'];

    try {
        // Check if the input is an email address
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Query for admin by email
            $stmtAdmin = $db->prepare("SELECT * FROM tblAdmin WHERE admin_email=?");
            $stmtAdmin->execute([$input]);
            $adminRow = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

            if ($adminRow) {
                // Verify the password for the admin
                if (password_verify($password, $adminRow['password'])) {
                    $_SESSION['email'] = $adminRow['admin_email']; // Storing admin email in session
                    $_SESSION['role'] = 'admin';
                    header("Location: /path-to-admin-dashboard.php");
                    exit();
                } else {
                    echo "Incorrect Admin Email or Password";
                }
            } else {
                echo "Incorrect Admin Email or Password";
            }
        } else {
            // If it's not an email, assume it's a username and query the tblUser
            $stmtUser = $db->prepare("SELECT * FROM tblUser WHERE username=?");
            $stmtUser->execute([$input]);
            $userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if ($userRow) {
                // Verify the password for the user
                if (password_verify($password, $userRow['password'])) {
                    $_SESSION['username'] = $userRow['username']; // Storing username in session
                    $_SESSION['role'] = $userRow['role'];
                    header("Location: homepage.php");
                    exit();
                } else {
                    echo "Incorrect Username or Password";
                }
            } else {
                echo "Incorrect Username or Password";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
