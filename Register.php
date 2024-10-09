<?php
include 'dbconn.php';

if (isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password
    $role = $_POST['role']; // Get the selected role

    // Prepare the SQL query
    $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES ('$fName', '$lName', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Optionally, you could redirect to a login page or another page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
}
?>
