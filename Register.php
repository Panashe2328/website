<?php
include 'dbconn.php'; // Include your database connection file
session_start(); // Start the session

if (isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
    $role = $_POST['role']; // Get the selected role

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fName, $lName, $email, $password, $role);

    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page or another page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close(); // Close the statement
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
            echo "Not Found, Incorrect Email or Password";
        }
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
    $stmt->close(); // Close the statement
}
?>
