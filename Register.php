<?php
include 'dbconn.php'; // Include your database connection file
session_start(); // Start the session

if (isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
    $role = $_POST['role']; // Get the selected role

    try {
        // Prepare the SQL query using prepared statements with PDO
        $stmt = $db->prepare("INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fName, $lName, $email, $password, $role]);

        echo "Registration successful!";
        // Redirect to login page or another page after successful registration
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query using prepared statements with PDO
        $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Verify the password against the hash
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role']; // Store the role in session

                // Check role and redirect accordingly
                if ($row['role'] === 'admin') {
                    header("Location: /path-to-admin-dashboard.php");
                } else {
                    header("Location: homepage.php");
                }
                exit();
            } else {
                echo "Incorrect Email or Password";
            }
        } else {
            echo "Incorrect Email or Password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
