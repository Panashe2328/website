<?php
session_start();
include 'dbconn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Can be username or email
    $password = $_POST['password'];

    // Check if the user is in the tblUser table (user role)
    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login); // Bind for both username and email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password matches the hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id']; // Set session ID for user
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            header("Location: index.php"); // Redirect to user dashboard or profile page
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "User does not exist.";
    }
}
?>
